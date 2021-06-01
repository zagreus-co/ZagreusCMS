<?php

namespace Modules\SEO\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SitemapController extends Controller
{
    protected $_category = null;
    protected $_post = null;
    protected $_page = null;

    public function __construct() {
        if (class_exists('\Modules\Blog\Entities\Category'))
            $this->_category = \Modules\Blog\Entities\Category::class;
            
        if (class_exists('\Modules\Blog\Entities\Post'))
            $this->_post = \Modules\Blog\Entities\Post::class;

        if (class_exists('\Modules\Page\Entities\Page'))
            $this->_page = \Modules\Page\Entities\Page::class;
    }

    public function index()
    {
        $sitemap = \App::make('sitemap');
        $sitemap->setCache('zagreus.sitemap_index', 60);

        if (!$sitemap->isCached()) {
            $sitemap->addSitemap( route('module.seo.sitemap.posts'), 
                !is_null($this->_post) ? $this->_post::latest()->first()->created_at : null
            );
            $sitemap->addSitemap( route('module.seo.sitemap.pages'), 
                !is_null($this->_page) ? $this->_page::latest()->first()->created_at : null
            );
            $sitemap->addSitemap(route('module.seo.sitemap.categories'));
        }

        return $sitemap->render('sitemapindex');
    }

    public function posts() {
        $sitemap = \App::make('sitemap');
        $sitemap->setCache('zagreus.posts_sitemap', 5);

        if (!$sitemap->isCached() && !is_null($this->_post)) {
            foreach ($this->_post::latest()->wherePublished(1)->get() as $post) {
                $sitemap->add(route("module.blog.posts.openBySlug", $post->slug), $post->created_at, 0.6, 'monthly', [
                    ['url'=> is_null($post->cover) ? themeAsset('images/404-cover-image.jpg') : asset($post->cover), "title"=> $post->title]
                ]);
            }
        }

        return $sitemap->render('xml');
    }
    
    public function pages() {
        $sitemap = \App::make('sitemap');
        $sitemap->setCache('zagreus.pages_sitemap', 60);

        if (!$sitemap->isCached() && !is_null($this->_page)) {
            foreach ($this->_page::latest()->wherePublished(1)->get() as $page) {
                $sitemap->add(route("module.page.show", $page->slug), $page->created_at, 0.5, 'monthly');
            }
        }

        return $sitemap->render('xml');
    }

    public function categories() {
        $sitemap = \App::make('sitemap');
        $sitemap->setCache('zagreus.categories_sitemap', 60);

        if (!$sitemap->isCached() && !is_null($this->_category)) {
            foreach ($this->_category::all() as $category) {
                $sitemap->add(route("module.blog.categories.view", $category->slug), null, 0.75, 'daily');
            }
        }

        return $sitemap->render('xml');
    }
    
}
