<?php

namespace VanOns\Laraberg;

use Illuminate\Support\ServiceProvider;

class LarabergServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/laraberg.php' => config_path('laraberg.php')], 'config');
        require __DIR__ . '/Http/routes.php';
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([__DIR__ . '/../public' => public_path('vendor/laraberg')], 'public');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Laraberg::class, function () {
            return new Laraberg();
        });
        $this->app->alias(Laraberg::class, 'laraberg');
    }
}

