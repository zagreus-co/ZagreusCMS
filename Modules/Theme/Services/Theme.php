<?php
namespace Modules\Theme\Services;

class Theme {
    public function currentName() {
        return get_option('front_theme');
    }
    public function panelTheme() {
        return get_option('panel_theme');
    }
}
