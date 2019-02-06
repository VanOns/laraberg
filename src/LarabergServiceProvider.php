<?php

namespace MauriceWijnia\Laraberg;

use Illuminate\Support\ServiceProvider;

class LarabergServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        require __DIR__ . '/Http/routes.php';
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laraberg');
        $this->publishes([__DIR__.'/../public' => public_path('vendor/laraberg')], 'public');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(Laraberg::class, function () {
            return new Laraberg();
        });
        $this->app->alias(Laraberg::class, 'laraberg');
    }
}