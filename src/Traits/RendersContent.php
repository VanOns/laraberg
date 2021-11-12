<?php

namespace VanOns\Laraberg\Traits;

use VanOns\Laraberg\Blocks\ContentRenderer;

use function app;

trait RendersContent
{
    protected $contentColumn = 'content';

    public function render(string $column = null): string
    {
        $column = $column ?: $this->contentColumn;
        $renderer = app(ContentRenderer::class);
        return $renderer->render($this->$column);
    }
}
