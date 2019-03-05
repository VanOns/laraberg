<?php

$namespace = 'MauriceWijnia\Laraberg\Http\Controllers\\';
Route::apiResource('laraberg/blocks', $namespace.'BlockController');
Route::apiResource('laraberg/media', $namespace.'MediaController');

Route::get('laraberg/oembed', $namespace.'OEmbedController');

Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');