<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class ZagreusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Theme', function() {
            return new \App\Services\Theme();
        });

        $this->app->singleton('Option', function() {
            return new \App\Models\Option();
        });

        $this->app->singleton('Hooks', function() {
            return new \App\Foundation\Hooks\Hooks();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('themeInclude',function($view){
            return '<?php echo themeView ('.$view.') ?>';
        });

        Blade::directive('panelView',function($view){
            return '<?php echo panelView ('.$view.') ?>';
        });

        Blade::directive('action',function($expression){
            return "<?php echo app('Hooks')->action({$expression}) ?>";
        });

        Blade::directive('filter',function($expression){
            return "<?php echo app('Hooks')->filter({$expression}) ?>";
        });

        if (Schema::hasTable('permissions')) {
            foreach(\App\Models\User\Permission::all() as $permission) {
                Gate::define($permission->tag, function (\App\Models\User $user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }
        }

        $this->register_panel_menus();
    }

    public function register_panel_menus() {
        add_panel_menu_item(
            menu_item_route: 'panel.index', 
            menu_item_icon:'fad fa-tachometer-alt', 
            menu_item_text: __('Dashboard'),
            priority: 1
        );

        add_panel_menu_item(
            menu_item_gate: 'manage_users',
            menu_item_route: 'panel.users.index', 
            menu_item_icon:'fad fa-users', 
            menu_item_text: __('Users'),
            priority: 2
        );

        add_panel_menu_item(
            menu_item_gate: 'manage_themes',
            menu_item_route: 'panel.theme.index', 
            menu_item_icon:'fas fa-palette', 
            menu_item_text: __('Themes'),
            priority: 4
        );

        add_panel_menu_item(
            menu_item_gate: 'manage_options',
            menu_item_route: 'panel.options.index', 
            menu_item_icon:'fad fa-toolbox', 
            menu_item_text: __('Options'),
            priority: 7
        );

        add_panel_menu_item(
            menu_item_gate: 'manage_media',
            menu_item_route: 'panel.media.index', 
            menu_item_icon:'fad fa-folder-open', 
            menu_item_text: __('Medias'),
            priority: 10
        );
    }
}
