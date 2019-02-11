<?php
$namespace = 'MauriceWijnia\Laraberg\Http\Controllers\\';

Route::get('laraberg', function() {
  return view('laraberg::index');
});

Route::apiResource('laraberg/blocks', $namespace.'BlockController');
Route::apiResource('laraberg/pages', $namespace.'PageController');
Route::resource('laraberg/ui/pages', $namespace.'UI\PageController');