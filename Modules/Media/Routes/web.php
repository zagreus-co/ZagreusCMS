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

Route::prefix('panel/media')->middleware('auth')->name('module.media.')->group(function() {
    Route::get('/', 'MediaController@index')->name('index');
    Route::post('/upload/attachments', 'MediaController@uploadAttachments')->name('upload.attachments');
    Route::post('/upload/cover', 'MediaController@uploadCover')->name('upload.cover');
});

Route::get('/media/open/{filename}', function($filename) {
    if (Storage::disk('media')->exists($filename)) {
        // return pathinfo(storage_path().'/app/media/'.$filename, PATHINFO_EXTENSION);
        
        return response()
            ->file( Storage::disk('media')->path($filename));
    }
    abort(404);
})->where('filename', '.*')->name('module.media.open');