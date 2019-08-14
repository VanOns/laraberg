<?php

namespace VanOns\Laraberg\Models;

use VanOns\Laraberg\Models\Content;
use VanOns\Laraberg\Events\ContentCreated;
use VanOns\Laraberg\Events\ContentUpdated;

trait Gutenbergable
{
    /**
     * Delete content when model gets deleted
     */
    protected static function bootGutenbergable()
    {
        // Persisting laraberg contents only when the current model has been updated
        self::saved(function ($model) {
            if ($content = $model->larabergContent) {
                $content->contentable()
                        ->associate($model)->save();
            }
        });

        // Permanently deleting laravel content when this model has been deleted
        self::deleted(function ($model) {
            $model->larabergContent()->delete();
        });
    }

    /**
     * Relationship to the lb_contents table.
     *
     * @return mixed
     */
    public function larabergContent()
    {
        return $this->morphOne(Content::class, 'contentable');
    }

    /**
     * Get the rendered content.
     *
     * @return string
     */
    public function getLbContentAttribute()
    {
        return $this->larabergContent ? $this->larabergContent->render() : '';
    }

    /**
     * Set the laraberg content.
     *
     * @param $content
     */
    public function setLbContentAttribute($content)
    {
        if (! $this->larabergContent) {
            $this->setRelation('larabergContent', new Content);
        }

        $this->larabergContent->setContent($content);
    }

    /**
     * Get the raw laraberg content.
     */
    public function getLbRawContentAttribute()
    {
        if (! $this->larabergContent) {
            return '';
        };

        return $this->larabergContent->raw_content;
    }

    /**
     * Returns the raw content that came out of Gutenberg
     *
     * @return String
     * @deprecated
     */
    public function getRawContent()
    {
        return $this->getLbRawContentAttribute();
    }

    /**
     * Returns the Gutenberg content with some initial rendering done to it
     *
     * @return String
     * @deprecated
     */
    public function getRenderedContent()
    {
        return $this->larabergContent->rendered_content;
    }

    /**
     * Sets the content object using the raw editor content
     *
     * @param String $content
     * @param String $save - Calls .save() on the Content object if true
     * @deprecated
     */
    public function setContent($content, $save = false)
    {
        if (! $this->larabergContent) {
            $this->createContent();
        }

        $this->larabergContent->setContent($content);
        if ($save) {
            $this->larabergContent->save();
        }
        event(new ContentUpdated($this->larabergContent));
    }
}
