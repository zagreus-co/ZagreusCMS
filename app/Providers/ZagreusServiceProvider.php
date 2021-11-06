<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
    }
}
