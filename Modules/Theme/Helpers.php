<?php

if (!function_exists('viewIfExist')) {
    function viewIfExist($view_name, $variables = [], $error_view = 'errors.theme404') {
        if ( view()->exists($view_name) ) {
            return view($view_name, $variables);
        }
        return view($error_view, compact('view_name'));
    }
}
if (!function_exists('themeView')) {
    function themeView($view, $variables = []) {
        return viewIfExist('themes.'.Theme::currentName().'.'.$view, $variables);
    }
}
if (!function_exists('themeAsset')) {
    function themeAsset($path, $secure = false) {
        return app('url')->asset('themes/'.Theme::currentName().'/'.$path, $secure);
    }
}

if (!function_exists('panelLayout')) {
    function panelLayout() {
        return 'panel::themes.'.Theme::panelTheme().'.layout';
    }
}

if (!function_exists('panelView')) {
    function panelView($view, $variables = []) {
        return viewIfExist('panel::themes.'.Theme::panelTheme().'.'.$view, $variables);
    }
}
if (!function_exists('panelAsset')) {
    function panelAsset($path, $secure = false) {
        return app('url')->asset('themes/'.Theme::panelTheme().'/'.$path, $secure);
    }
}