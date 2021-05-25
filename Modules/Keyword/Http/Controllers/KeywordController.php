<?php

namespace Modules\Keyword\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Keyword\Entities\Keyword;

class KeywordController extends Controller
{
    public function view($keyword) {
        $keywords = Keyword::where("keyword", "LIKE", "%$keyword%")
            ->limit(25)
            ->latest()
            ->get()
            ->unique('keywordable_id');
        
        \SEO::setTitle('کلید واژه '.$keyword.' - '.\Option::get('site_short_name')->data)
            ->setDescription(\Option::get('site_description')->data);
        \SEOMeta::setKeywords(\Option::get('site_keywords')->data);

        return themeView('keywords', compact('keywords'));
    }
}
