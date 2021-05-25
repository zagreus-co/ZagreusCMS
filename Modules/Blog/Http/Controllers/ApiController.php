<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Category;
use Illuminate\Database\Eloquent\Builder;

class ApiController extends Controller
{
    public function posts() {
        $posts = Post::where('release_time', '<=', \Carbon\Carbon::now())
            ->wherePublished(1)
            ->whereHas('categories', function (Builder $query) {
                $query->where('category_id', '=',\Option::get('main_category')->data)
                    ->orWhere('category_id', 3);
            })
            ->orderBy("release_time", 'desc')->paginate(\Option::get('index_posts_count')->data);
        $posts->each(function($post, $key) {
            $post->image = $post->medias()->whereTag('cover')->first();
            $post->image = (is_null($post->image) ? themeAsset('images/404-cover-image.jpg') : route('index').'/media/open/'.$post->image->filename);

            $post->release_time = jdate($post->release_time)->ago();

            $content = explode(' ',strip_tags($post->content));
            $post->content = implode(" ", array_splice( $content , 0, \Option::get('index_string_count')->data )  ).' [...]';
            
            $post->url = route('post', $post->slug);
            return $post;
        });
        return $posts;
    }

    public function viewPost(Post $post) {
        if (!$post->published || $post->release_time >= \Carbon\Carbon::now()) abort(404);
        $post->image = $post->medias()->whereTag('cover')->first();
        $post->image = (is_null($post->image) ? themeAsset('images/404-cover-image.jpg') : route('index').'/media/open/'.$post->image->filename);

        $post->release_time = jdate($post->release_time)->ago();
        $post->user_id = $post->user()->first()->full_name;
        if ($post->medias()->whereTag('attachment')->count() > 0) {
            $attachments = [];
            foreach( $post->medias()->whereTag('attachment')->get() as $attachment ) {
                $attachments[] = route('index').'/media/open/'.$attachment->filename;
            }
            $post->attachments = $attachments;
        }
        return $post;
    }

    public function postsInCategory(Category $category) {
        $posts = Post::where('release_time', '<=', \Carbon\Carbon::now())
            ->wherePublished(1)
            ->whereHas('categories', function (\Illuminate\Database\Eloquent\Builder $query) use($category) {
                $query->where('category_id', '=', $category->id);
            })
            ->orderBy("release_time", 'desc')->paginate(\Option::get('index_posts_count')->data);

        return $posts;
    }

    public function categories() {
        return Category::whereParentId(null)->get()->each(function($category, $key) {
            unset($category->parent_id);
            $category->child;
        });
        
    }
}
