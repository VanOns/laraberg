<?php

namespace VanOns\Laraberg\Helpers;

use VanOns\Laraberg\Models\Block;

class BlockHelper {
  public static function renderBlocks($html) {
    $regex = '/<!-- wp:block {"ref":(\d*)} \/-->/';
    $result = preg_replace_callback($regex, function($matches) {
      return self::renderBlock($matches[1]);
    }, $html);
    return $result;
  }

  private static function renderBlock($id) {
    $block = Block::find($id);
    if ($block) {
      return $block->render();
    } else {
      return 'Block not found';
    }
  }
}