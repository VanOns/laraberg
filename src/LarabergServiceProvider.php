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
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        }

        require_once __DIR__ . '/Blocks/wp.php';
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BlockTypeRegistry::class, function () {
            return BlockTypeRegistry::getInstance();
        });

        $this->app->alias(ContentRenderer::class, 'laraberg.renderer');
        $this->app->alias(BlockParser::class, 'laraberg.parser');
        $this->app->alias(OEmbedService::class, 'laraberg.embed');
        $this->app->alias(BlockTypeRegistry::class, 'laraberg.registry');
    }
}

