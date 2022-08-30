<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index() {
        SEOMeta::setTitle(get_option('site_short_name').' - '.get_option('site_tag_line'))
            ->setDescription(get_option('site_description'))
            ->setKeywords(get_option('site_keywords'));

        return themeView('index');
    }
}
