<?php

namespace MauriceWijnia\Laraberg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends ApplicationController {
  public function index() {
    return $this->ok();
  }

  public function store(Request $request) {
    $path = Storage::putFile('public/laraberg', $request->file('file'));
    $url = Storage::url($path);
    return $this->ok($this->linkToJson($url));
  }

  public function show(Request $request, $id) {
    return $this->ok();
  }

  public function update(Request $request, $id) {
    return $this->ok();
  }

  public function destroy() {
    return $this->notFound();
  }

  public function linkToJson($link) {
    return [
      'id' => 1,
      'link' => $link,
      'source_url' => $link,
      'title' => ['raw' => '', 'rendered' => '']
    ];
  }
}