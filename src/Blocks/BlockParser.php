<?php

namespace VanOns\Laraberg\Blocks;

use VanOns\Laraberg\Blocks\Wordpress\WordPressBlockParser;

class BlockParser
{
    /**
     * @var WordPressBlockParser
     */
    protected WordPressBlockParser $parser;

    public function __construct(WordPressBlockParser $parser)
    {
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
