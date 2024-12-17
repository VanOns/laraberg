<?php

namespace VanOns\Laraberg\Blocks;

class BlockTypeRegistry
{
    /**
     * @var static|BlockTypeRegistry|null
     */
    protected static ?BlockTypeRegistry $instance;

    /**
     * @var BlockType[]
     */
    protected array $blockTypes = [];

    public static function getInstance(): BlockTypeRegistry
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function register(
        string $name,
        array $attributes = [],
        callable $renderCallback = null
    ): void {
        $this->blockTypes[] = new BlockType($name, $attributes, $renderCallback);
    }

    /**
     * @return array
     */
    public function blockTypes(): array
    {
        return $this->blockTypes;
    }

    /**
     * @param string $name
     * @return BlockType|null
     */
    public function getBlockType(string $name): ?BlockType
    {
        $arr = array_filter(
            $this->blockTypes(),
            function ($blockType) use ($name) {
                return $blockType->name === $name;
            }
        );

        return array_shift($arr);
    }
}
