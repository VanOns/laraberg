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
        Laraberg::registerBlockType('example/example-block', [], function ($attributes, $content) {
            return "<h1>Dynamic</h1>";
        });
    }
}
