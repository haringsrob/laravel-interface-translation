<?php

namespace Haringsrob\LaravelInterfaceTranslation;

use Haringsrob\LaravelInterfaceTranslation\Commands\UpdateTranslations;
use Haringsrob\LaravelInterfaceTranslation\Http\Livewire\TranslationList;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LaravelInterfaceTranslationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-interface-translation');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-interface-translation');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if (config('laravel-interface-translation.load-routes')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/ui.php');
        }

        Livewire::component('laravel-interface-translation.list', TranslationList::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-interface-translation.php'),
            ], ['config', 'laravel-interface-translation-config']);

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-interface-translation'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../dist' => public_path('vendor/laravel-interface-translation'),
            ], 'assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-interface-translation'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([UpdateTranslations::class]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-interface-translation');

        // Register the main class to use with the facade
        $this->app->singleton(LaravelInterfaceTranslation::class, function () {
            return new LaravelInterfaceTranslation();
        });
    }
}
