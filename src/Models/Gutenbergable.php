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
     * Get the rendered content
     */
    public function getLbContentAttribute() {
        return $this->content->render();
    }

    /**
     * Set the content
     * @param String $content - Gutenberg output
     */
    public function setLbContentAttribute($content)
    {   
        if (!$this->content) { $this->createContent(); }

        $this->content->setContent($content);
        $this->content->save();
        event(new ContentUpdated($this->content));
    }

    /**
     * Get the raw gutenberg output
     */
    public function getLbRawContentAttribute() {
        return $this->content->raw_content;
    }

    /**
     * Creates a content object and associates it with the parent object
     */
    private function createContent()
    {
        $content = new Content;
        $this->content()->save($content);
        $this->content = $content;
        event(new ContentCreated($content));
    }

    /**
     * Delete content when model gets deleted
     */
    protected static function bootGutenbergable()
    {   
        self::deleting(function ($model) {
            $model->content()->delete();
        });
    }

    /**
     * DEPRECATED
     */

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
     * Sets the content object using the raw editor content
     * @param String $content
     * @param String $save - Calls .save() on the Content object if true
     */
    public function setContent($content, $save = false)
    {   
        if (!$this->content) { $this->createContent(); }

        $this->content->setContent($content);
        if ($save) { $this->content->save(); }
        event(new ContentUpdated($this->content));
    }
}
