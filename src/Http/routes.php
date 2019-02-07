<?php

Route::get('laraberg', function() {
  return view('laraberg::index');
});

Route::get('laraberg/wp/v2/types', function() {
  return 'Types';
});

Route::get('laraberg/wp/v2/types/post', function() {
  return 'Post';
});

Route::get('laraberg/wp/v2/types/page', function() {
  return 'Page';
});
