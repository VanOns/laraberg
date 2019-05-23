<?php namespace VanOns\Laraberg\Http\Controllers;

use Illuminate\Http\Request;

class BlockController extends ApplicationController
{
    protected $blockModel;

    public function __construct()
    {
        $this->blockModel = config("laraberg.models.block");
        $this->blockModel = new $this->blockModel;
    }

    public function index()
    {
        $blocks = $this->blockModel->all();
        return $this->ok($blocks);
    }

    public function store(Request $request)
    {
        $block = $this->blockModel;
        $block->raw_title = $request->title;
        $block->status = $request->status;
        $block->setContent($request->content);
        $block->updateSlug();
        $block->save();

        return $this->ok($block->toJson(), 201);
    }

    public function show(Request $request, $id)
    {
        $block = $this->blockModel->find($id);

        if (!$block) {
            return $this->notFound();
        }

        return $this->ok($block);
    }

    public function update(Request $request, $id)
    {
        $block = $this->blockModel->find($id);

        if (!$block) {
            return $this->notFound();
        }

        $block->raw_title = $request->title;
        $block->status = $request->status;
        $block->setContent($request->content);
        $block->updateSlug();
        $block->save();
        return $this->ok($block);
    }

    public function destroy($id)
    {
        $block = $this->blockModel->find($id);

        if (! $block) {
            return $this->notFound();
        }

        $block->delete();

        return $this->ok();
    }
}
