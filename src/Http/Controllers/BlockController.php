<?php

namespace VanOns\Laraberg\Http\Controllers;

use Illuminate\Http\Request;

use VanOns\Laraberg\Models\Block;

class BlockController extends ApplicationController
{
    public function index()
    {
        $blocks = Block::all();
        return $this->ok($blocks);
    }
    // PHP
    public function store(Request $request)
    {
        $block = new Block();
        $block->title = $request->title;
        $block->status = $request->status;
        $block->setContent($request->content);
        $block->updateSlug();
        $block->save();
        return $this->ok($block->toJson(), 201);
    }

    public function show(Request $request, $id)
    {
        $block = Block::find($id);
        if (!$block) {
            return $this->notFound();
        }
        return $this->ok($block);
    }

    public function update(Request $request, $id)
    {
        $block = Block::find($id);
        if (!$block) {
            return $this->notFound();
        }
        $block->title = $request->title;
        $block->status = $request->status;
        $block->setContent($request->content);
        $block->updateSlug();
        $block->save();
        return $this->ok($block);
    }

    public function destroy(Request $request, $id)
    {
        $block = Block::find($id);
        if (!$block) {
            return $this->notFound();
        }
        $block->delete();
        return $this->ok();
    }
}

