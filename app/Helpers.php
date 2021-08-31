<?php

if ( !function_exists('locales') ) {
    function locales() { return config('app.available_locales'); }
}

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

if (!function_exists('themeTemplates')) {
    function themeTemplates() {
        $path = '../resources/views/themes/'.Theme::currentName().'/templates';

        try { $files = scandir($path); }
        catch (\Throwable $th) { return null; }

        $templates = [];

        foreach ($files as $key => $file) {
            if (is_dir($path.'/'.$file)) continue;

            $firstLine = trim(fgets(fopen($path.'/'.$file, 'r')));

            $templates[str_replace('.blade.php', '',$file)] = grabThemeKey('name', $firstLine);
        }

        return ($templates);
    }
}

if (!function_exists('grabThemeKey')) {
    function grabThemeKey($key, $string) {
        preg_match('/<!--[\s\S](.*):[\s\S](.*)[\s\S]-->/', $string, $output_array);
        
        return count($output_array) == 3 && $output_array[1] == $key ? $output_array[2] : null;
    }
}