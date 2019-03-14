<?php

namespace VanOns\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;

use VanOns\Laraberg\Events\ContentRendered;
use VanOns\Laraberg\Helpers\BlockHelper;
use VanOns\Laraberg\Helpers\EmbedHelper;

class Content extends Model {

  protected $table = 'lb_contents';

  public function contentable() {
    return $this->morphTo();
  }

  /**
   * Returns the rendered content of the content
   */
  public function render() {
    $html = BlockHelper::renderBlocks($this->rendered_content);
    return "<div class='gutenberg__content wp-embed-responsive'>$html</div>";
  }

  public function setContent($html) {
    $this->raw_content = $html;
    $this->renderRaw();
  }

  /**
   * Renders the HTML of the content object
   */
  public function renderRaw() {
    $this->rendered_content = EmbedHelper::renderEmbeds($this->raw_content);
    event(new ContentRendered($this));
    return $this->rendered_content;
  }
}