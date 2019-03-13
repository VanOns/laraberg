<?php

namespace VanOns\Laraberg\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use VanOns\Laraberg\Models\Block;

class BlockController extends ApplicationController {
  public function index() {
    $blocks = Block::all();
    return $this->ok($blocks);
  }

  public function store(Request $request) {
    $block = new Block();
    $block->slug = $request->title;
    $block->title = $request->title;
    $block->content = $request->content;
    $block->status = $request->status;
    $block->save();
    return $this->ok($block->toJson(), 201);
  }

  public function show(Request $request, $id) {
    $block = Block::find($id);
    if (!$block) {
      return $this->notFound();
    }
    return $this->ok($block);
  }

  public function update(Request $request, $id) {
    $block = Block::find($id);
    if (!$block) {
      return $this->notFound();
    }
    $block->slug = $request->title;
    $block->title = $request->title;
    $block->content = $request->content;
    $block->status = $request->status;
    $block->save();
    return $this->ok($block);
  }

  public function destroy() {
    return $this->notFound();
  }
}