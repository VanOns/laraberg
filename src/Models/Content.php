<?php

namespace MauriceWijnia\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;
use Embed\Embed;

use MauriceWijnia\Laraberg\Jobs\RenderJob;

class Content extends Model {
  protected $table = 'lb_contents';

  public function contentable() {
    return $this->morphTo();
  }

  /**
   * Returns the rendered content of the content
   */
  function render() {
    $html = '<div class="gutenberg__content wp-embed-responsive">'.$this->rendered_content.'</div>';
    return $html;
  }

  function setContent($html) {
    $this->raw_content = $html;
    $this->rendered_content = $this->renderRaw($html);
  }

  /**
   * Renders the HTML of the content object
   */
  function renderRaw($raw) {
    $html = $raw;
    $html = $this->renderBlocks($html);
    $html = $this->renderEmbeds($html);
    return $html;
  }

  function renderBlocks($html) {
    // TODO
    // $split = preg_replace_callback('/<!-- wp:block {"ref":(\d*)} \/-->/', function($matches) {
    //   return $matches[0] . "\n" . Block::find($matches[1])->content['raw'];
    // }, $content);
    return $html;
  }

  function renderEmbeds($html) {
    $result = preg_replace_callback('/<!-- wp:core-embed\/.*?--><figure class="wp-block-embed.*?".*?<div class="wp-block-embed__wrapper">(.*?)<\/div><\/figure>/', function($matches) {
      $embed = Embed::create($matches[1])->code;
      return str_replace('>'.$matches[1].'<', '>'.$embed.'<', $matches[0]);
    }, $html);
    return $result;
  }
}