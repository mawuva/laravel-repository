<?php

namespace Mawuekom\Repository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        require_once __DIR__.'/helpers.php';
        
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'repository');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'repository');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/repository.php' => config_path('repository.php'),
                base_path('vendor/spatie/laravel-query-builder/config/query-builder.php') =>config_path('query-builder.php'),
                base_path('vendor/spatie/laravel-json-api-paginate/config/json-api-paginate.php') =>config_path('json-api-paginate.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/repository'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/repository'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/repository'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/repository.php', 'repository');

        // Register the main class to use with the facade
        $this->app->singleton('repository', function () {
            return new Repository;
        });
    }
}
