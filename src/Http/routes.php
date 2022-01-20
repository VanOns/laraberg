<?php

use VanOns\Laraberg\Controllers\BlockRendererController;
use VanOns\Laraberg\Controllers\OEmbedController;

Route::group(['prefix' => config('laraberg.prefix'), 'middleware' => config('laraberg.middlewares')], function () {
    Route::get('oembed', [OEmbedController::class, 'show']);
    Route::get('block-renderer', [BlockRendererController::class, 'show']);
});
