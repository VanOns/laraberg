<?php

namespace MauriceWijnia\Laraberg\Models;

use MauriceWijnia\Laraberg\Models\Page;

trait Gutenbergable {

  public function page() {
    return $this->morphOne(Page::class, 'pageable');
  }

  public function createPage($content) {
    $page = new Page;
    $page->content = $content;
    $this->page()->save($page);
  }

  public function renderPage() {
    return $this->page->render();
  }

  public function getContent() {
    return $this->page->content;
  }

  public function setContent($content, $save = false) {
    $this->page->content = $content;
    if ($save) {
      $this->page->save();
    }
  }
}