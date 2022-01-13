<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use VanOns\Laraberg\Laraberg;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Laraberg::registerBlockType('example/example-block-2', [], function ($attributes, $content) {
            return "<div>Test</div>";
        });

        Laraberg::registerBlockType('example/example-block', [], function ($attributes, $content) {
            return "<div style='background-color: black; color: white; padding: 1rem'>{$content}<p>Dynamic block</p></div>";
        });
    }
}
