<?php

namespace VanOns\Laraberg\Blocks;

class ContentRenderer
{
    /**
     * @var BlockParser
     */
    private $parser;

    public function __construct(BlockParser $parser)
    {
        $this->parser = $parser;
    }

    public function render(string $content): string
    {
        $output = '';
        $blocks = $this->parser->parse($content);

        foreach ($blocks as $block) {
            $output .= $block->render();
        }

        return $output;
    }
}
