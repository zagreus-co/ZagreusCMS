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

Route::middleware('guest')->group( function() {
    Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login');

    if (get_option('allow_register'))
        Route::match(['get', 'post'], 'register', 'AuthController@register')->name('register');
    
    Route::get('/forget-password/{type?}', 'AuthController@forgetPassword')->name('password.request.email');
    Route::post('/forget-password/{type?}', 'AuthController@sendPasswordLink')->name('password.reset');
    
    Route::get('user/reset-password/email/{token}', 'AuthController@resetPasswordUsingEmail')->middleware('guest')->name('password.reset');
    Route::post('user/reset-password/email', 'AuthController@updatePasswordUsingEmail')->middleware('guest')->name('password.update');

});

Route::get('logout', 'AuthController@logout')->middleware('auth')->name('logout');

Route::middleware('auth')->name('module.user.')->group(function() {
    Route::resource('panel/users', 'UserController');
    Route::get('/panel/users/{user}/login', 'UserController@loginUsingId')->name('users.loginUsingId');
    Route::resource('panel/roles', 'RolesController');
    Route::match(['get', 'post'], 'panel/profile', 'ProfileController@index')->name('profile');
});
