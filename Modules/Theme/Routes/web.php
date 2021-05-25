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

Route::prefix('panel/theme')->middleware('auth')->name('module.theme.')->group(function() {
    Route::get('/', 'ThemeController@index')->name('index');
    Route::post('/select', 'ThemeController@selectTheme')->name('selectTheme');
});

Route::get('panel/theme/{theme}/screenshot', function($theme){
    $path = base_path("resources\\views\\themes\\{$theme}\\screenshot.png");

    if(!File::exists($path)) {
        return response()->json(['message' => 'Image not found.'], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('module.theme.image');
