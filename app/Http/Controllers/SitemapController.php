<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = \App::make('sitemap');        

        $_sitemap = \Hooks::filter('sitemap.index', $sitemap);

        return $sitemap->render('sitemapindex');
    }
}
