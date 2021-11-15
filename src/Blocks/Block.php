<?php

namespace VanOns\Laraberg\Blocks;

class Block
{
    /**
     * @var string
     */
    public $blockName;
    /**
     * @var array
     */
    public $attributes;
    /**
     * @var array
     */
    public $innerBlocks;
    /**
     * @var string
     */
    public $innerHTML;
    /**
     * @var array
     */
    public $innerContent;

    /** @var BlockTypeRegistry */
    protected $registry;

    public function __construct(
        string $blockName,
        array $attributes = [],
        array $innerBlocks = [],
        string $innerHTML = '',
        array $innerContent = []
    ) {
        $this->blockName   = $blockName;
        $this->attributes  = $attributes;
        $this->innerBlocks = $innerBlocks;
        $this->innerHTML = $innerHTML;
        $this->innerContent = $innerContent;

        $this->registry = app('laraberg.registry');
    }

    public function render(): string
    {
        $output = '';

        $index = 0;
        foreach($this->innerContent as $innerContent) {
            $output .= is_string($innerContent)
                ? $innerContent
                : $this->innerBlocks[$index++]->render();
        }

        $blockType = $this->registry->getBlockType($this->blockName);
        if ($blockType && $blockType->isDynamic()) {
            $output = call_user_func($blockType->renderCallback, $this->attributes, $output, $this);
        }

        return $output;
    }

    public static function fromArray(array $args): Block
    {
        $innerBlocks = [];
        foreach ($args['innerBlocks'] ?? [] as $innerBlock) {
            $innerBlocks[] = static::fromArray($innerBlock);
        }

        return new static(
            $args['blockName'],
            $args['attrs'] ?? [],
            $innerBlocks,
            $args['innerHTML'] ?? '',
            $args['innerContent'] ?? []
        );
    }
}
