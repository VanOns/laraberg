<?php

namespace MauriceWijnia\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {
  protected $table = 'lb_pages';

  protected $casts = [
    'content' => 'array'
  ];

  public function pageable() {
    return $this->morphTo();
  }

    /**
   * Transform content to wordpress content object
   */
  function setContentAttribute($content) {
    $this->attributes['content'] = json_encode([ 'raw' => $content ]);
  }

  /**
   * Transform content to empty string if null
   * because Gutenberg cannot handle null values
   */
  function getContentAttribute() {
    $content = json_decode($this->attributes['content'], true);
    if ($content['raw'] == null) {
      $content['raw'] = "";
    }
    return $content;
  }

  /**
   * Renders the HTML of the page object
   */
  function render() {
    return $this->renderBlocks();
  }

  function renderBlocks() {
    $split = preg_replace_callback('/<!-- wp:block {"ref":(\d*)} \/-->/', function($matches) {
      return $matches[0] . "\n" . Block::find($matches[1])->content['raw'];
    }, $this->content['raw']);
    return $split;
  }
}