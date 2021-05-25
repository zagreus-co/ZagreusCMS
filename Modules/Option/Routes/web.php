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
Route::prefix('panel/option')->name('module.options.')->middleware('auth')->group(function() {
    Route::get('/', 'OptionController@index')->name('index');
    Route::get('/table', 'OptionController@table')->name('table');

    Route::post('/handle', 'OptionController@handle')->name('handle');
    Route::delete('/delete/{option}', 'OptionController@delete')->name('delete');
});
