<?php

namespace VanOns\Laraberg;

use Illuminate\Support\ServiceProvider;
use VanOns\Laraberg\Blocks\BlockParser;
use VanOns\Laraberg\Blocks\BlockTypeRegistry;
use VanOns\Laraberg\Blocks\ContentRenderer;
use VanOns\Laraberg\Services\OEmbedService;

class LarabergServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/laraberg.php' => config_path('laraberg.php')], 'config');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([__DIR__ . '/../public' => public_path('vendor/laraberg')], 'public');

        if (config('laraberg.use_package_routes')) {
            require_once __DIR__ . '/Http/routes.php';
        };

        /**
         * Bindings
         */

        $this->app->bind('laraberg.renderer', ContentRenderer::class);
        $this->app->bind('laraberg.parser', BlockParser::class);
        $this->app->bind('laraberg.embed', OEmbedService::class);
        $this->app->bind('laraberg.registry', BlockTypeRegistry::class);

        $this->app->singleton(BlockTypeRegistry::class, function () {
            return BlockTypeRegistry::getInstance();
        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

