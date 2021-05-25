<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/posts', 'ApiController@posts')->name('api.posts');
Route::post('/post/{post}', 'ApiController@viewPost');
Route::post('/posts_in_category/{category}', 'ApiController@postsInCategory');
Route::post('/categories', 'ApiController@categories');