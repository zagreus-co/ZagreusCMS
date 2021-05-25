<?php
use Illuminate\Support\Facades\Route;

if(! function_exists('isActive') ) {
    
    function isActive($key , $activeClassName = 'active', $default = '') {

        if(is_array($key)) {
            return in_array(Route::currentRouteName() , $key) ? $activeClassName : $default;
        }

        // check for naming patterns like: module.moduleName.*
        if(!is_array($key) && strpos($key, '*') !== false) {
            return (strpos(Route::currentRouteName(), str_replace('*', '', $key)) !== false) ? $activeClassName :  $default;
        }

        return Route::currentRouteName() == $key ? $activeClassName :  $default;
    }

}
