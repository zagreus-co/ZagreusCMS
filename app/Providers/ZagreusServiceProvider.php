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

        if (Schema::hasTable('permissions')) {
            foreach(\App\Models\User\Permission::all() as $permission) {
                Gate::define($permission->tag, function (\App\Models\User $user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }
        }
    }
}
