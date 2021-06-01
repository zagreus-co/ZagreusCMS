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

Route::get('/sitemap_index.xml', 'SitemapController@index')->name('module.seo.sitemap.index');
Route::get('/posts_sitemap.xml', 'SitemapController@posts')->name('module.seo.sitemap.posts');
Route::get('/pages_sitemap.xml', 'SitemapController@pages')->name('module.seo.sitemap.pages');
Route::get('/categories_sitemap.xml', 'SitemapController@categories')->name('module.seo.sitemap.categories');