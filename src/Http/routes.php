<?php

$namespace = 'VanOns\Laraberg\Http\Controllers\\';
Route::apiResource('laraberg/blocks', $namespace.'BlockController');
Route::get('laraberg/oembed', $namespace.'OEmbedController');
