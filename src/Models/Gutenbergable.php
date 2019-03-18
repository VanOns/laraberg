<?php

namespace VanOns\Laraberg\Models;

use VanOns\Laraberg\Models\Content;
use VanOns\Laraberg\Events\ContentCreated;
use VanOns\Laraberg\Events\ContentUpdated;

trait Gutenbergable
{

    public function content()
    {
        return $this->morphOne(Content::class, 'contentable');
    }

    /**
     * Creates a content object and associates it with the parent object
     * @param String $html
     */
    public function createContent($html)
    {
        $content = new Content;
        $content->setContent($html);
        $this->content()->save($content);
        event(new ContentCreated($content));
    }

    /**
     * Returns the rendered HTML from the Content object
     * @return String
     */
    public function renderContent()
    {
        return $this->content->render();
    }

    /**
     * Returns the raw content that came out of Gutenberg
     * @return String
     */
    public function getRawContent()
    {
        return $this->content->raw_content;
    }

    /**
     * Returns the Gutenberg content with some initial rendering done to it
     * @return String
     */
    public function getRenderedContent()
    {
        return $this->content->rendered_content;
    }

    /**
     * Sets the content of the Content object to the provided content
     * @param String $content
     * @param String $save - Calls .save() on the Content object if true
     */
    public function setContent($content, $save = false)
    {
        $this->content->setContent($content);
        if ($save) {
            $this->content->save();
        }
        event(new ContentUpdated($this->content));
    }
}
