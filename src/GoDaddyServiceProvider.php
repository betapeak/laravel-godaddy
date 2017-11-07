<?php

namespace BetaPeak\GoDaddy;

use Illuminate\Support\ServiceProvider;

class GoDaddyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-godaddy.php' => $this->app->configPath().'/'.'laravel-godaddy.php',
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-godaddy.php', 'laravel-godaddy');

        $this->app->singleton('laravel-godaddy', function () {
            return new GoDaddy();
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides() : array
    {
        return ['laravel-godaddy'];
    }
}