<?php

namespace mauricewijnia\Laraberg;

use Illuminate\Support\ServiceProvider;

class LarabergServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
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