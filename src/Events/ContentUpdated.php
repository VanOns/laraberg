<?php

namespace VanOns\Laraberg\Events;

use Illuminate\Queue\SerializesModels;

use VanOns\Laraberg\Models\Content;

class ContentUpdated
{
    use SerializesModels;

    public $content;

    /**
     * Create a new event instance
     * 
     * @param VanOns\Laraberg\Models\Content $content
     * @return void
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }
}
