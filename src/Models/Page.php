<?php

namespace MauriceWijnia\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;
use Embed\Embed;

use MauriceWijnia\Laraberg\Jobs\RenderJob;

class Page extends Model {
  protected $table = 'lb_pages';

  public function pageable() {
    return $this->morphTo();
  }

  // /**
  //  * Transform content to empty string if null
  //  * because Gutenberg cannot handle null values
  //  */
  // function getRawContentAttribute() {
  //   $content = $this->attributes['raw_content'];
  //   if ($content == null) {
  //     $content = "";
  //   } 

  //   return $content;
  // }

  /**
   * Returns the rendered content of the page
   */
  function render() {
    $html = '<div class="gutenberg__content wp-embed-responsive">'.$this->rendered_content.'</div>';
    return $html;
  }

  function setContent($content) {
    $this->raw_content = $content;
    $this->rendered_content = $this->renderRaw($content);
  }

  /**
   * Renders the HTML of the page object
   */
  function renderRaw($raw) {
    $html = $raw;
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