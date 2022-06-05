<?php

namespace Modules\Analytics\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Analytics\Entities\Analytic;

class AnalyticsServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Analytics';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'analytics';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        app()->make('router')->pushMiddlewareToGroup('web', \Modules\Analytics\Http\Middleware\Analytic::class);
        
        \Hooks::addAction('panel.widgets.report_cards', function() {
            $analytics = [
                'yesterdayViewers'=> Analytic::whereDate('created_at', \Carbon\Carbon::yesterday())->get()->groupBy(function($row) { return $row->ip; })->count(),
                'todayViewers'=> Analytic::whereDate('created_at', \Carbon\Carbon::today())->get()->groupBy(function($row) { return $row->ip; })->count(),
                
            ];
            echo view('analytics::widgets.report-card', compact('analytics')); 
        }, 2);

        \Hooks::addAction('panel.widgets.main', function() {
            echo view('analytics::widgets.dashboard-chart'); 
        });

        add_panel_menu_item(
            menu_item_gate: 'manage_analytics',
            menu_item_route: 'module.analytics.*', 
            menu_item_icon:'stats-chart', 
            menu_item_text: __('Analytics'),
            menu_item_extra: [
                'dropdowns'=> [
                    [
                        "menu_item_route"=> 'module.analytics.index', 
                        "menu_item_icon"=> __('return-down-forward'), 
                        "menu_item_text"=>  __('View analytics')
                    ],
                    [
                        "menu_item_route"=> 'module.analytics.rules', 
                        "menu_item_icon"=> __('return-down-forward'), 
                        "menu_item_text"=>  __('Analytic rules')
                    ]
                ],
            ]
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
