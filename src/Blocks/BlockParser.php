<?php

namespace VanOns\Laraberg\Blocks;

class BlockParser
{
    /** @var WP_Block_Parser */
    protected WP_Block_Parser $parser;

    public function __construct(WP_Block_Parser $parser) {
        $this->parser = $parser;
    }
    /**
     * @param string $content
     * @return Block[]
     */
    public function parse(string $content): array
    {
        $blocks = $this->parser->parse($content);

        return array_map(function ($block) {
            return Block::fromArray((array) $block);
        }, $blocks);
    }
}
