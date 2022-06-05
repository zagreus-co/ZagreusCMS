<?php
use Illuminate\Support\Facades\Route;

// Global Helpers
if ( !function_exists('locales') ) { function locales() { return config('app.available_locales'); } }

// Panel Helpers
if(! function_exists('isActive') ) {
    function isActive($key , $activeClassName = 'active', $default = '') {
        if(is_array($key))
            return in_array(Route::currentRouteName() , $key) ? $activeClassName : $default;

        // check for naming patterns like: module.moduleName.*
        if(!is_array($key) && strpos($key, '*') !== false)
            return (strpos(Route::currentRouteName(), str_replace('*', '', $key)) !== false) ? $activeClassName :  $default;

        return Route::currentRouteName() == $key ? $activeClassName :  $default;
    }
}

// Panel-Theme helpers

if (!function_exists('add_panel_menu_item')) {
    function add_panel_menu_item(string $menu_item_route, string $menu_item_icon, string $menu_item_text, string|null $menu_item_gate = null, int $priority = 10, array $menu_item_extra = []) {
        \Hooks::addAction('panel.menu_items', function() use($menu_item_gate, $menu_item_route, $menu_item_icon, $menu_item_text, $menu_item_extra) {
            echo panelView('menu-item', [
                'menu_item_gate'=> $menu_item_gate,
                'menu_item_route'=> $menu_item_route,
                'menu_item_icon'=> $menu_item_icon,
                'menu_item_text'=> $menu_item_text,
                'menu_item_extra'=> $menu_item_extra
            ]);
        }, $priority);
    }
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
        return 'panel.layouts.'.Theme::panelTheme().'.layout';
    }
}

if (!function_exists('panelView')) {
    function panelView($view, $variables = []) {
        return viewIfExist('panel.layouts.'.Theme::panelTheme().'.'.$view, $variables);
    }
}
if (!function_exists('panelAsset')) {
    function panelAsset($path, $secure = false) {
        return app('url')->asset('themes/'.strtolower(Theme::panelTheme()).'/'.$path, $secure);
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

// Panel-User helpers
if (!function_exists('checkGate')) {
    function checkGate($gate) {
        if (gettype($gate) == 'array') {
            foreach($gate as $value) {
                if (\Gate::allows($value)) return true;
            }
            return false;
        }

        if (gettype($gate) == 'string') return \Gate::allows($gate);
        
        echo 'error@Helpers::checkGate : Wrong gate type';
        return false;
    }
}

// Option helpers
if (! function_exists('get_option')) {
    function get_option($tag, $default = null) {
        try {
            return \Cache::remember('Option::'.$tag.'-'.app()->getLocale(), 14400, function () use ($tag, $default) {
                $option = \Option::whereTag($tag)->first();
                if (is_null($option)) return $default;
                
                return ($option->is_translatable ? $option->data : $option->plain_data);
            });
        } catch (\Throwable $th) {
            return $default;
        }
    }
}

if (! function_exists('update_option')) {
    function update_option($option, $data) {
        if (gettype($option) == 'integer')
            $option = \Option::find($option);
        elseif (gettype($option) == 'string')
            $option = \Option::whereTag($option)->first();
        
        if (is_null($option) || get_class($option) != 'App\Models\Option') {
            // if $option variable was string, it means it is actually holding the option tag
            if (gettype($option) == 'string') {
                \Option::create(array_merge($data, ['tag'=> $option]));
            }
            return false;
        }

        \Cache::forget('Option::'.$option->tag.'-'.app()->getLocale());
        $option->update($data);
        return true;
    }
}