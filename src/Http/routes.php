<?php

Route::group(['prefix' => config('laraberg.prefix'), 'middleware' => config('laraberg.middlewares')], function () {
    Route::get('oembed', [\VanOns\Laraberg\Controllers\OEmbedController::class, 'show']);
});
