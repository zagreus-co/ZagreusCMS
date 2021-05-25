<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    \SEO::setTitle(get_option('site_short_name').' - '.get_option('site_tag_line'))
        ->setDescription(get_option('site_description'));
    \SEOMeta::setKeywords(get_option('site_keywords'));

    return themeView('index');
})->name('index');

Route::get('locale/{locale}',function($locale){
    \Session::put('locale',$locale);
    return redirect()->back();   
})->name('locale');