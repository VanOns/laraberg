<?php

namespace VanOns\Laraberg\Helpers;

use VanOns\Laraberg\Models\Block;

class BlockHelper
{
    /**
     * Renders any blocks in the HTML (recursively)
     * @param String $html
     */
    public static function renderBlocks($html)
    {
        // Replace reusable block ID with reusable block HTML
        $regex = '/<!-- wp:block {"ref":(\d*)} \/-->/';
        $result = preg_replace_callback($regex, function ($matches) {
            return self::renderBlock($matches[1]);
        }, $html);
        return $result;
    }

    /**
     * Returns the HTML of the Block with $id
     * @param Int $id
     */
    private static function renderBlock($id)
    {
        $block = Block::find($id);
        if ($block) {
            return $block->render();
        } else {
            return 'Block not found';
        }
    }
}
