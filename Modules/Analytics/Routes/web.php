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

Route::prefix('panel/analytics')->name('module.analytics.')->middleware('auth')->group(function() {
    Route::get('/', 'AnalyticsController@index')->name('index');
    Route::match(['get', 'post'], '/rules', 'AnalyticsController@rules')->name('rules');
    Route::delete('/rules/{rule}/delete', 'AnalyticsController@deleteRule')->name('rules.delete');
});
