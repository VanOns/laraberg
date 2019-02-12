<?php

namespace MauriceWijnia\Laraberg\Http\Controllers\UI;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use MauriceWijnia\Laraberg\Database\Models\Page;
use MauriceWijnia\Laraberg\Http\Controllers\ApplicationController;

class PageController extends ApplicationController {
  public function index() {
    $pages = Page::all();
    return view('laraberg::pages/index', ['pages' => $pages]);
  }

  public function store(Request $request) {
    $page = Page::create($request->all());
    return $this->notFound();
  }

  public function create() {
    return view('laraberg::pages/create');
  }

  public function show(Request $request, $id) {
    $page = Page::find($id);
    if (!$page) {
      return $this->notFound();
    }
    return view('laraberg::pages/show', ['page' => $page]);
  }

  public function edit(Request $request, $id) {
    $page = Page::find($id);
    if (!$page) {
      return $this->notFound();
    }
    return view('laraberg::pages/edit', ['page' => $page]);
  }

  public function update(Request $request, $id) {
    $page = Page::find($id);
    if (!$page) {
      return $this->notFound();
    }
    return $this->notFound();
  }

  public function destroy(Request $request, $id) {
    $page = Page::find($id);
    if (!$page) {
      return $this->notFound();
    }
    $page->delete();
    return $this->toIndex();
  }

  private function toIndex() {
    return redirect()->action('\\MauriceWijnia\Laraberg\Http\Controllers\UI\PageController@index');
  }
}