<?php

namespace VanOns\Laraberg\Traits;

use VanOns\Laraberg\Blocks\ContentRenderer;

use function app;

trait RendersContent
{
    public function render(string $column = null): string
    {
        $column = $column ?: $this->getContentColumn();
        $renderer = app(ContentRenderer::class);
        $content = $this->{$column};
        return $renderer->render(is_string($content) ? $content : '');
    }

    protected function getContentColumn()
    {
        if (property_exists($this, 'contentColumn')) {
            return $this->contentColumn;
        }

        return 'content';
    }
}
