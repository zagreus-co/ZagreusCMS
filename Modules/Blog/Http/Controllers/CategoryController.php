<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if (! checkGate('manage_categories') ) abort(403);

        if ($request->ajax()) return 1;
        if (class_exists('\SEO')) \SEO::setTitle(__('Manage categories'));

        $categories = Category::query()
            ->orderBy('id', 'desc')
            ->orderBy('parent_id', 'desc')
            ->paginate(25);

        return view('blog::categories.index', compact('categories'));
    }

    public function create()
    {
        if (! checkGate('manage_categories') ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Create category'));
        return view('blog::categories.create');
    }

    public function store(Request $request)
    {
        if (! checkGate('manage_categories') ) abort(403);

        $request->validate($this->rules());
        
        if ($request->parent_id != 0) {
            $request->validate(['parent_id'=> 'exists:blog__categories,id']);
        }

        $data = [
            'parent_id'=> $request->parent_id == 0 ? null : $request->parent_id,
        ];
        foreach(locales() as $locale => $value) {
            $data[$locale] = $request->{$locale};
            $data[$locale]['slug'] = generateSlug($request->filled("{$locale}.generate_slug") ? $request->{$locale}['title'] : $request->{$locale}['slug'], Category::class);
        }

        $category = Category::create($data);

        if ($request->filled('image')) {
            $category->medias()->create([
                'user_id'=> auth()->user()->id,
                'tag'=> 'cover',
                'filename'=> 'covers/'.$request->image
            ]);
        }

        alert()->success(__('Category created successfully!'));
        return redirect( route('module.blog.categories.index') );
    }

    public function edit(Category $category)
    {
        if (! checkGate('manage_categories') ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Edit category'));
        return view('blog::categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (! checkGate('manage_categories') ) abort(403);

        $request->validate($this->rules());
        
        if ($request->parent_id != 0) {
            $request->validate(['parent_id'=> 'exists:blog__categories,id']);
        }

        $data = [
            'parent_id'=> $request->parent_id == 0 ? null : $request->parent_id,
        ];
        foreach(locales() as $locale => $value) {
            $data[$locale] = $request->{$locale};
            $data[$locale]['slug'] = generateSlug($request->filled("{$locale}.generate_slug") ? $request->{$locale}['title'] : $request->{$locale}['slug'], Category::class, $category->id);
        }

        $category->update($data);

        if ($request->filled('image')) {
            $category->medias()->whereTag('cover')->delete();
            $category->medias()->create([
                'user_id'=> auth()->user()->id,
                'tag'=> 'cover',
                'filename'=> 'covers/'.$request->image
            ]);
        }

        alert()->success(__('Category updated successfully!'));
        return back();
    }

    public function destroy(Category $category)
    {
        if (! checkGate('manage_categories') ) abort(403);
        
        $category->delete();
        $category->medias()->delete();
        alert()->success(__('Category deleted successfully!'));
        return back();
    }

    public function view($slug) {
        $category = Category::whereTranslation('slug', $slug)->first();
        if (is_null($category)) abort(404);
        
        \SEO::setTitle($category->title.' - '.get_option('site_short_name'))
            ->setDescription(get_option('site_description'));
        \SEOMeta::setKeywords(get_option('site_keywords'));
        
        return themeView('catoryable', ['datas'=> $category->posts()->wherePublished(1)->orderBy('id', 'desc')->get()]);
    }

    public function sitemap() {
        $sitemap = \App::make('sitemap');
        $sitemap->setCache('zagreus.categories_sitemap', 60);

        if (!$sitemap->isCached()) {
            foreach (Category::get() as $category) {
                $sitemap->add(route("module.blog.categories.view", $category->slug), null, 0.75, 'daily');
            }
        }

        return $sitemap->render('xml');
    }

    protected function rules() {
        return [
            config('app.locale').'.title'=> ['required', 'min:2'],
            'parent_id'=> ['required', 'numeric'],
        ];
    }
    protected function generateSlug($value, $current = null) {
        $value = \Str::slug($value == '' ? time() : $value);
        $slugCount = Category::whereTranslation('slug', $value);
        if (!is_null($current))
            $slugCount = $slugCount->where('id', '!=', $current);
        if ( $slugCount->count() > 0 )
            $value .= '-'.time();
        return $value;
    }
}
