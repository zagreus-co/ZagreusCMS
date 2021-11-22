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

Route::prefix('panel/blog')->middleware('auth')->name('module.blog.')->group(function() {
    Route::resource('/categories', 'CategoryController');
    Route::resource('/posts', 'PostController');
    Route::post('/posts/move', 'PostController@move')->name('posts.move');
    Route::get('/posts/{post}/toggle_publish', 'PostController@togglePublish')->name('posts.togglePublish');
});

Route::get('/search/{keyword}', 'PostController@search');

Route::get('/p/{post}', 'PostController@openPostById')->name('module.blog.posts.openById');
Route::get('/post/{slug}', 'PostController@openPostBySlug')->name('module.blog.posts.openBySlug');

Route::get('category/{slug}', 'CategoryController@view')->name('module.blog.categories.view');

Route::get('/posts_sitemap.xml', 'PostController@sitemap')->name('module.blog.posts.sitemap');
Route::get('/categories_sitemap.xml', 'CategoryController@sitemap')->name('module.blog.categories.sitemap');