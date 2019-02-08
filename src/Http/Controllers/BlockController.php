<?php

namespace MauriceWijnia\Laraberg\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use MauriceWijnia\Laraberg\Models\Block;

class BlockController extends ApplicationController {
  public function index() {
    $blocks = Block::all();
    return $this->ok($blocks, 201);
  }

  public function store(Request $request) {
    $block = Block::create($request->all());
    $block->save();
    return $this->ok($block->toJson());
  }

  public function show($id) {
    return $this->notFound();
  }

  public function update(Request $request, $id) {
    $block = Block::find($id);
    $block->slug = $request->title;
    $block->update(Block::permittedParams($request->all()));
    return $this->ok($block);
  }

  public function destroy() {
    return $this->notFound();
  }
}