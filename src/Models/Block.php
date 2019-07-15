<?php

namespace VanOns\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;

use VanOns\Laraberg\Helpers\BlockHelper;
use VanOns\Laraberg\Helpers\EmbedHelper;
use VanOns\Laraberg\Helpers\SlugHelper;

class Block extends Model
{
    protected $table = 'lb_blocks';
    protected $appends = ['content', 'title'];
    protected $hidden = [
        'created_at', 
        'raw_content',
        'raw_title',
        'rendered_content',
        'updated_at'
    ];

    // TODO: Only here to make migration run, should be cleaned up on release
    protected $casts = ['old_title' => 'array'];

    /**
     * Updates slug according to title
     */
    public function updateSlug()
    {
        $this->slug = SlugHelper::slugify($this->raw_title);
    }

    /**
     * Returns the rendered content of the block
     * @return String - The completely rendered content
     */
    public function render()
    {
        return BlockHelper::renderBlocks($this->rendered_content);
    }

    /**
     * Renders the content of the Block object
     * @return String
     */
    public function renderRaw()
    {
        $this->rendered_content = EmbedHelper::renderEmbeds($this->raw_content);
        return $this->rendered_content;
    }

    /**
     * Sets the raw content and performs some initial rendering
     * @param String $html
     */
    public function setContent($content)
    {
        $this->raw_content = $content;
        $this->renderRaw();
    }

    /**
     * Returns a content object similar to WordPress
     * @return Array
     */
    public function getContentAttribute()
    {
        return [
            'raw' => $this->raw_content,
            'rendered' => $this->rendered_content,
            'protected' => false,
            'block_version' => 1
        ];
    }

    /**
     * Returns a content object similar to WordPress
     * @return Array
     */
    public function getTitleAttribute()
    {
        return [
            'raw' => $this->raw_title,
        ];
    }
}

