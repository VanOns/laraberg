<?php

namespace MauriceWijnia\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;
use Embed\Embed;

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
    $html = '<div class="gutenberg__content wp-embed-responsive">'.$this->content['raw'].'</div>';
    $html = $this->renderBlocks($html);
    $html = $this->renderEmbeds($html);
    return $html;
  }

  function renderBlocks($content) {
    $split = preg_replace_callback('/<!-- wp:block {"ref":(\d*)} \/-->/', function($matches) {
      return $matches[0] . "\n" . Block::find($matches[1])->content['raw'];
    }, $content);
    return $split;
  }

  function renderEmbeds($content) {
    $result = preg_replace_callback('/<!-- wp:core-embed\/.*?--><figure class="wp-block-embed.*?".*?<div class="wp-block-embed__wrapper">(.*?)<\/div><\/figure>/', function($matches) {
      $embed = Embed::create($matches[1])->code;
      return str_replace('>'.$matches[1].'<', '>'.$embed.'<', $matches[0]);
    }, $content);
    return $result;
  }
}