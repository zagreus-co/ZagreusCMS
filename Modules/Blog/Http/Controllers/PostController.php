<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Category;
use Morilog\Jalali\Jalalian;

class PostController extends Controller
{

    public function index(Request $request)
    {

        if (! checkGate('manage_blog') ) abort(403);

        if ($request->ajax()) return $this->table();
        if (class_exists('\SEO')) \SEO::setTitle(__('Manage posts'));
        return view('blog::posts.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (! checkGate('manage_blog') ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Create post'));
        return view('blog::posts.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request) {
        if (! checkGate('manage_blog') ) abort(403);

        $request->validate($this->rules());
        
        $data = [
            'template'=> !is_null($request->template) && $request->template != 'null' ? $request->template : null,
            'category_id'=> $request->category_id,
            "can_comment"=> $request->filled('can_comment'),
            "published"=> $request->filled('published')
        ];

        foreach(locales() as $locale => $value) {
            $data[$locale] = $request->{$locale};
            $data[$locale]['slug'] = generateSlug($request->filled("{$locale}.generate_slug") ? $request->{$locale}['title'] : $request->{$locale}['slug'], Post::class);
        }

        $post = auth()->user()->posts()->create($data);
        
        if ($request->filled('keywords')) {
            $request->validate([
                'keywords'=> ['array']
            ]);
            foreach ($request->keywords as $keyword) {
                $post->keywords()->create(['keyword'=> $keyword]);
            }
        }

        if ($request->filled('attachments')) {
            $request->validate(['attachments'=> 'array']);
            $post->medias()->whereTag('attachment')->delete();

            foreach($request->attachments as $attachment) {
                $post->medias()->create([
                    'user_id'=> auth()->user()->id,
                    'tag'=> 'attachment',
                    'filename'=> $attachment
                ]);
            }
        } else { $post->medias()->whereTag('attachment')->delete(); }

        if ($request->filled('image_url')) {
            $post->medias()->create([
                'user_id'=> auth()->user()->id,
                'tag'=> 'cover',
                'filename'=> $request->image_url
            ]);
        }
        
        alert()->success(__('Post created successfully!'));
        return redirect( route('module.blog.posts.index') );
    }

    public function show($id) { return back(); }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Post $post)
    {
        if (! checkGate('manage_blog') ) abort(403);
    
        if (class_exists('\SEO')) \SEO::setTitle(__('Edit post'));
        return view('blog::posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Post $post)
    {
        if (! checkGate('manage_blog') ) abort(403);
        
        $request->validate($this->rules());
        
        $data = [
            'template'=> !is_null($request->template) && $request->template != 'null' ? $request->template : null,
            'category_id'=> $request->category_id,
            "can_comment"=> $request->filled('can_comment'),
            "published"=> $request->filled('published')
        ];

        foreach(locales() as $locale => $value) {
            $data[$locale] = $request->{$locale};
            $data[$locale]['slug'] = generateSlug($request->filled("{$locale}.generate_slug") ? $request->{$locale}['title'] : $request->{$locale}['slug'], Post::class, $post->id);
        }

        $post->update($data);
        
        if ($request->filled('keywords')) {
            $request->validate([
                'keywords'=> ['array']
            ]);
            foreach ($request->keywords as $keyword) {
                $post->keywords()->create(['keyword'=> $keyword]);
            }
        }

        if ($request->filled('attachments')) {
            $request->validate(['attachments'=> 'array']);
            $post->medias()->whereTag('attachment')->delete();

            foreach($request->attachments as $attachment) {
                $post->medias()->create([
                    'user_id'=> auth()->user()->id,
                    'tag'=> 'attachment',
                    'filename'=> $attachment
                ]);
            }
        } else { $post->medias()->whereTag('attachment')->delete(); }

        if ($request->filled('image_url')) {
            $post->medias()->create([
                'user_id'=> auth()->user()->id,
                'tag'=> 'cover',
                'filename'=> $request->image_url
            ]);
        }

        alert()->success(__('Post edited successfully!'));
        return redirect( route('module.blog.posts.index') );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Post $post)
    {
        if (! checkGate('manage_blog') ) abort(403);
        
        $post->medias()->delete();
        $post->keywords()->delete();
        $post->comments()->delete();

        $post->delete();
        alert()->success(__('Post deleted successfully!'));
        return back();
    }

    public function search($keyword) {
        $posts = Post::query()
            ->where('title', 'LIKE', "%$keyword%")
            ->where('release_time', '<=', \Carbon\Carbon::now())
            ->wherePublished(1)
            ->orWhere('content', 'LIKE', "%$keyword%")
            ->where('release_time', '<=', \Carbon\Carbon::now())
            ->wherePublished(1)
            ->paginate(get_option('index_posts_count'));
        
        \SEO::setTitle(__('Search').' - '.get_option('site_short_name'))
            ->setDescription(get_option('site_description'));
        \SEOMeta::setKeywords(get_option('site_keywords'));

        return themeView('search', compact('posts'));
    }

    public function openPostBySlug($slug) {
        $post = Post::whereTranslation('slug', $slug)
            ->wherePublished(1)
            ->first();
        if (!$post) abort(404);

        $comments = $post->comments()->whereParentId(0)->wherePublished(1)->latest()->get();

        \SEO::setTitle($post->title.' - '.get_option('site_short_name'))
            ->setDescription(mb_substr(strip_tags($post->content), 0, 151).' [...]');
        if ($post->keywords()->count() > 0)
            \SEOMeta::setKeywords($post->keywords->pluck('keyword')->toArray());

        return themeView(is_null($post->template) ? 'post' : 'templates.'.$post->template, compact('post', 'comments'));
    }
    public function openPostById(Post $post) {
        if (\Carbon\Carbon::parse($post->release_time) >= \Carbon\Carbon::now() || !$post->published) abort(404);
        return redirect( route('module.blog.posts.openBySlug', $post->slug) );
    }

    protected function rules() {
        return [
            config('app.locale').".title" => ['required', 'string'],
            config('app.locale').".content" => ['required', 'string'],
            "category_id" => ['required', 'numeric']
        ];
    }
}
