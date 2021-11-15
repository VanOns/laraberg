<?php

namespace VanOns\Laraberg\Blocks;

class BlockParser
{
    /**
     * @param string $content
     * @return Block[]
     */
    public function parse(string $content): array
    {
        /**
         * We copy the exact implementation for WP_Block_Parser from WordPress
         */
        require_once __DIR__ . '/wp.php';

        return array_map(function ($block) {
            return Block::fromArray($block);
        }, (new WP_Block_Parser())->parse($content));
    }
}
