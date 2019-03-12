<?php

namespace MauriceWijnia\Laraberg\Events;

use Illuminate\Queue\SerializesModels;

use MauriceWijnia\Laraberg\Models\Content;

class ContentCreated {
  use SerializesModels;
  public $content;

  /**
   * Create a new event instance
   * 
   * @param MauriceWijnia\Laraberg\Models\Content $content
   * @return void
   */
  public function __construct(Content $content) {
    $this->content = $content;
  }
}