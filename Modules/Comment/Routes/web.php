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

Route::prefix('comment')->name('module.comment.')->group(function() {
    Route::post('/submit', 'CommentController@submit')->name('submit');
});

Route::prefix('/panel/comments')->middleware('auth')->name('module.comment.')->group(function() {
    Route::get('/', 'CommentController@index')->name('index');
    Route::post('/report', 'CommentController@report')->name('report');
    Route::get('/toggle_publish/{comment}', 'CommentController@togglePublish')->name('togglePublish');
    Route::patch('/{comment}', 'CommentController@update')->name('update');
    Route::delete('/{comment}', 'CommentController@destroy')->name('destroy');
});