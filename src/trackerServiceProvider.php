<?php

namespace sportakal\tracker;

use Illuminate\Support\ServiceProvider;

class trackerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'sportakal');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'sportakal');
         $this->loadMigrationsFrom(__DIR__.'/database/migrations/');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $router->middleware('Tracker', 'sportakal/tracker/middlewares/Tracker');
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tracker.php', 'tracker');

        // Register the service the package provides.
        $this->app->singleton('tracker', function ($app) {
            return new tracker;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['tracker'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/tracker.php' => config_path('tracker.php'),
        ], 'tracker.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/sportakal'),
        ], 'tracker.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/sportakal'),
        ], 'tracker.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/sportakal'),
        ], 'tracker.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
