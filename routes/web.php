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

// Panel routes
Route::prefix('panel/')->middleware('auth')->name('panel.')->group(function() {
    
    // Panel-Theme routes
    Route::get('/theme', 'Panel\ThemeController@index')->name('theme.index');
    Route::post('/theme/select', 'Panel\ThemeController@selectTheme')->name('theme.selectTheme');
    Route::get('/theme/{theme}/screenshot', 'Panel\ThemeController@themeScreenshot')->name('theme.image');
});
