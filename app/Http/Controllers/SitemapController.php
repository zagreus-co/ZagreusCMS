<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = \App::make('sitemap');        

        $_sitemap = \Hooks::filter('sitemap.index', $sitemap);
        // $sitemap->addSitemap( route('module.seo.sitemap.pages'), 
        //     !is_null($this->_page) ? $this->_page::latest()->first()->created_at : null
        // );
        // $sitemap->addSitemap(route('module.seo.sitemap.categories'));

        return $sitemap->render('sitemapindex');
    }
}
