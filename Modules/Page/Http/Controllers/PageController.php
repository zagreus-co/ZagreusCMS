<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if (! checkGate(['manage_pages']) ) abort(403);

        if ($request->ajax()) return $this->table();
        if (class_exists('\SEO')) \SEO::setTitle(__('Manage pages'));
        return view('page::index');
    }
    
    public function show($slug) {
        $page = Page::whereTranslation('slug', $slug)
            ->wherePublished(1)
            ->first();
        if (!$page) abort(404);

        \SEO::setTitle($page->title.' - '.get_option('site_short_name'))
            ->setDescription(mb_substr(strip_tags($page->content), 0, 151).' [...]');
        if ($page->keywords()->count() > 0)
            \SEOMeta::setKeywords($page->keywords->pluck('keyword')->toArray());

        return themeView(is_null($page->template) ? 'page' : $page->template, compact('page'));
    }

    public function create()
    {
        if (! checkGate(['manage_pages']) ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Create new page'));
        return view('page::create');
    }

    public function store(Request $request)
    {
        if (! checkGate(['manage_pages']) ) abort(403);
        $request->validate($this->rules());

        $data = [
            'published'=> $request->published,
            'display_in_header'=> $request->filled('display_in_header'),
            'can_comment'=> $request->filled('can_comment')
        ];
        foreach(locales() as $locale => $value) {
            $data[$locale] = $request->{$locale};
            $data[$locale]['slug'] = generateSlug($request->filled("{$locale}.generate_slug") ? $request->{$locale}['title'] : $request->{$locale}['slug'], Page::class);
        }

        $page = Page::create($data);

        if ($request->filled('keywords')) {
            $request->validate([
                'keywords'=> ['array']
            ]);
            foreach ($request->keywords as $keyword) {
                $page->keywords()->create(['keyword'=> $keyword]);
            }
        }

        alert()->success(__("Page created successfully!"));
        return redirect( route('module.page.index') );
    }

    public function edit(Page $page)
    {
        if (! checkGate(['manage_pages']) ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__("Edit page"));
        return view('page::edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        if (! checkGate(['manage_pages']) ) abort(403);
        
        $request->validate($this->rules());

        $data = [
            'published'=> $request->published,
            'display_in_header'=> $request->filled('display_in_header'),
            'can_comment'=> $request->filled('can_comment')
        ];
        foreach(locales() as $locale => $value) {
            $data[$locale] = $request->{$locale};
            $data[$locale]['slug'] = generateSlug($request->filled("{$locale}.generate_slug") ? $request->{$locale}['title'] : $request->{$locale}['slug'], Page::class, $page->id);
        }

        $page->update($data);

        if ($request->filled('keywords')) {
            $request->validate([
                'keywords'=> ['array']
            ]);
            foreach ($request->keywords as $keyword) {
                $page->keywords()->create(['keyword'=> $keyword]);
            }
        }

        alert()->success(__("Page edited successfully!"));
        return back();
    }

    public function destroy(Page $page)
    {
        if (! checkGate(['manage_pages']) ) abort(403);

        $page->keywords()->delete();
        $page->comments()->delete();
        $page->delete();
        alert()->success(__("Page deleted successfully!"));
        return back();
    }

    protected function rules() {
        return [
            config('app.locale').'.title'=> ['required', 'min:2'],
            config('app.locale').'.content'=> ['required'],
            'published'=> ['required', 'boolean', 'min:0', 'max:1']
        ];
    }
}
