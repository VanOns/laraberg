<?php
$namespace = 'MauriceWijnia\Laraberg\Http\Controllers\\';

Route::get('laraberg', function() {
  return view('laraberg::index');
});

Route::apiResource('laraberg/blocks', $namespace.'BlockController');