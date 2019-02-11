<?php

namespace MauriceWijnia\Laraberg\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use MauriceWijnia\Laraberg\Database\Models\Page;

class PageController extends ApplicationController {
  public function index() {
    $pages = Page::all();
    return $this->ok($pages);
  }

  public function store(Request $request) {
    $page = Page::create($request->all());
    $page->save();
    return $this->ok($page->toJson(), 201);
  }

  public function show($id) {
    $page = Page::find($id) ?: $this->notFound();
    return $this->ok($page);
  }

  public function update(Request $request, $id) {
    $page = Page::find($id) ?: $this->notFound();;
    $page->update(Page::permittedParams($request->all()));
    return $this->ok($page);
  }

  public function destroy() {
    return $this->notFound();
  }
}