<?php

namespace MauriceWijnia\Laraberg\Models;

use MauriceWijnia\Laraberg\Models\Content;
use MauriceWijnia\Laraberg\Events\ContentCreated;

trait Gutenbergable {

  public function content() {
    return $this->morphOne(Content::class, 'contentable');
  }

  public function createContent($html) {
    $content = new Content;
    $content->setContent($html);
    $this->content()->save($content);
    event(new ContentCreated($content));
  }

  public function renderContent() {
    return $this->content->render();
  }

  public function getRawContent() {
    return $this->content->raw_content;
  }

  public function getRenderedContent() {
    return $this->content->rendered_content;
  }

  public function setContent($content, $save = false) {
    $this->content->setContent($content);
    if ($save) {
      $this->content->save();
    }
  }
}