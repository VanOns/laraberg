<?php

namespace VanOns\Laraberg;

use VanOns\Laraberg\Blocks\BlockTypeRegistry;

class Laraberg
{
    public static function registerBlockType(string $name, array $attributes = [], callable $renderCallback = null)
    {
        /** @var BlockTypeRegistry $registry */
        $registry = app(BlockTypeRegistry::class);
        $registry->register($name, $attributes, $renderCallback);
    }
}
