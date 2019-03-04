<?php

namespace MauriceWijnia\Laraberg\Models;

use MauriceWijnia\Laraberg\Models\Page;

trait Gutenbergable {

  public function page() {
    return $this->morphOne(Page::class, 'pageable');
  }

  public function createPage($content) {
    $page = new Page;
    $page->setContent($content);
    $this->page()->save($page);
  }

  public function renderPage() {
    return $this->page->render();
  }

  public function getRawContent() {
    return $this->page->raw_content;
  }

  public function getRenderedContent() {
    return $this->page->rendered_content;
  }

  public function setContent($content, $save = false) {
    $this->page->setContent($content);
    if ($save) {
      $this->page->save();
    }
  }
}