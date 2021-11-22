<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('panel/pages')->name('module.page.')->middleware('auth')->group(function() {
    Route::get('/', 'PageController@index')->name('index');
    Route::get('/create', 'PageController@create')->name('create');
    Route::post('/store', 'PageController@store')->name('store');
    Route::get('/{page}/edit', 'PageController@edit')->name('edit');
    Route::patch('/{page}', 'PageController@update')->name('update');
    Route::delete('/{page}', 'PageController@destroy')->name('destroy');
});

Route::get('page/{slug}', 'PageController@show')->name('module.page.show');
Route::get('/pages_sitemap.xml', 'PageController@sitemap')->name('module.page.sitemap');
