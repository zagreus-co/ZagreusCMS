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
    }
}
