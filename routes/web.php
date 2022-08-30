<?php
use Illuminate\Support\Facades\Route;

// Global routes
Route::get('/', 'HomeController@index')->name('index');

Route::get('/media/open/{filename}', 'MediaController@open')->where('filename', '.*')->name('media.open');

// Guest only routes
Route::middleware('guest')->group( function() {
    Route::match(['get', 'post'], 'login', 'Panel\User\AuthController@login')->name('login');

    if (get_option('allow_register'))
        Route::get('register', 'Panel\User\AuthController@register')->name('register');
        Route::post('register', 'Panel\User\AuthController@doRegister')->name('register.post');

    Route::get('/forget-password/{type?}', 'Panel\User\AuthController@forgetPassword')->name('password.request.email');
    Route::post('/forget-password/{type?}', 'Panel\User\AuthController@sendPasswordLink')->name('password.reset');
    
    Route::get('user/reset-password/email/{token}', 'Panel\User\AuthController@resetPasswordUsingEmail')->middleware('guest')->name('password.reset');
    Route::post('user/reset-password/email', 'Panel\User\AuthController@updatePasswordUsingEmail')->middleware('guest')->name('password.update');

});

// Panel routes
Route::prefix('panel/')->middleware('auth')->name('panel.')->group(function() {
    
    Route::get('/', 'Panel\PanelController@index')->name('index');
    
    // Panel-User routes
    Route::resource('/users/roles', 'Panel\User\RolesController');
    Route::resource('/users', 'Panel\User\UserController');
    Route::get('/users/{user}/login', 'Panel\User\UserController@loginUsingId')->name('users.loginUsingId');
    Route::match(['get', 'post'], '/profile', 'Panel\User\ProfileController@index')->name('profile');
    Route::get('/logout', 'Panel\User\AuthController@logout')->middleware('auth')->name('logout');

    // Panel-Theme routes
    Route::get('/theme', 'Panel\ThemeController@index')->name('theme.index');
    Route::post('/theme/select', 'Panel\ThemeController@selectTheme')->name('theme.selectTheme');
    Route::get('/theme/{theme}/screenshot', 'Panel\ThemeController@themeScreenshot')->name('theme.image');

    // Panel-Option routes
    Route::get('/option', 'Panel\OptionController@index')->name('options.index');
    Route::post('/handle', 'Panel\OptionController@handle')->name('options.handle');

    // Panel-Media routes
    Route::get('/media', 'MediaController@index')->name('media.index');
    Route::post('/media/admin_upload', 'MediaController@adminUpload')->name('media.admin_upload');
});
