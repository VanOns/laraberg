<?php

if (config('laraberg.use_package_routes')) {
    Route::group(['prefix' => config('laraberg.prefix'), 'middleware' => config('laraberg.middlewares')], function () {
        Route::apiResource('blocks', 'VanOns\Laraberg\Http\Controllers\BlockController');
        Route::get('oembed', 'VanOns\Laraberg\Http\Controllers\OEmbedController');
    });
};
