<?php

namespace MauriceWijnia\Laraberg\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use MauriceWijnia\Laraberg\Database\Models\Block;

class BlockController extends ApplicationController {
  public function index() {
    $blocks = Block::all();
    return $this->ok($blocks);
  }

  public function store(Request $request) {
    $block = Block::create($request->all());
    $block->save();
    return $this->ok($block->toJson(), 201);
  }

  public function show($id) {
    $block = Block::find($id) ?: $this->notFound();
    return $this->ok($block);
  }

  public function update(Request $request, $id) {
    $block = Block::find($id) ?: $this->notFound();
    $block->slug = $request->title;
    $block->update(Block::permittedParams($request->all()));
    return $this->ok($block);
  }

  public function destroy() {
    return $this->notFound();
  }
}