<?php

namespace MauriceWijnia\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model {
  protected $table = 'lb_blocks';

  protected $casts = [
    'title' => 'array',
    'content' => 'array'
  ];

  /**
   * Updates slug according to title
   */
  public function updateSlug() {
    $this->slug = $this->title['raw'];
  }

  /**
   * Transforms title to wordpress title object
   * @param string $title
   */
  function setTitleAttribute($title) {
    $this->attributes['title'] = json_encode([ 'raw' => $title ]);
  }

  /**
   * Transform content to wordpress content object
   */
  function setContentAttribute($content) {
    $this->attributes['content'] = json_encode([ 'raw' => $content ]);
  }

  /**
   * Transforms value to wordpress slug
   */
  function setSlugAttribute($title) {
    $this->attributes['slug'] = $this->slugify($title);
  }

  /**
   * Generates a slug from the provided text
   * @param string $text
   * 
   * @return string slug
   */
  public function slugify($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }
}