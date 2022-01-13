<?php

namespace VanOns\Laraberg\Blocks;

class BlockTypeRegistry
{
    /** @var static */
    protected static $instance;

    /** @var BlockType[] */
    protected $blockTypes = [];

    public static function getInstance(): BlockTypeRegistry
    {
        if (!isset(static::$instance)) {
            static::$instance = new BlockTypeRegistry();
        }

        return static::$instance;
    }

    public function register(string $name, array $attributes = [], callable $renderCallback = null) {
        $this->blockTypes[] = new BlockType($name, $attributes, $renderCallback);
    }

    public function blockTypes(): array
    {
        return $this->blockTypes;
    }

    /**
     * @param string $name
     * @return BlockType|null
     */
    public function getBlockType(string $name)
    {
        $arr = array_filter($this->blockTypes(), function ($blockType) use ($name) {
            return $blockType->name === $name;
        });

        return array_shift($arr);
    }
}
