<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ZagreusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('start_time', fn () => microtime(true));

        $this->app->singleton('Theme', function () {
            return new \App\Services\Theme();
        });

        $this->app->singleton('Option', function () {
            return new \App\Models\Option();
        });

        $this->app->singleton('Hooks', function () {
            return new \App\Foundation\Hooks\Hooks();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('themeInclude', function ($view) {
            return '<?php echo themeView (' . $view . ') ?>';
        });

        Blade::directive('panelView', function ($view) {
            return '<?php echo panelView (' . $view . ') ?>';
        });

        Blade::directive('action', function ($expression) {
            return "<?php echo app('Hooks')->action({$expression}) ?>";
        });

        Blade::directive('filter', function ($expression) {
            return "<?php echo app('Hooks')->filter({$expression}) ?>";
        });

        $this->register_panel_menus();
    }

    public function register_panel_menus()
    {
        add_panel_menu_item(
            menu_item_route: 'panel.index',
            menu_item_icon: 'planet',
            menu_item_text: __('Dashboard'),
            priority: 1
        );

        add_panel_menu_item(
            menu_item_gate: 'manage_users',
            menu_item_route: 'panel.users.index',
            menu_item_icon: 'people',
            menu_item_text: __('Users'),
            priority: 2
        );

        add_panel_menu_item(
            menu_item_gate: 'manage_themes',
            menu_item_route: 'panel.theme.index',
            menu_item_icon: 'color-palette',
            menu_item_text: __('Themes'),
            priority: 4
        );

        add_panel_menu_item(
            menu_item_gate: 'manage_options',
            menu_item_route: 'panel.options.index',
            menu_item_icon: 'settings-outline',
            menu_item_text: __('Options'),
            priority: 7
        );
    }
}
