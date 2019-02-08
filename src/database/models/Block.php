<?php

namespace MauriceWijnia\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model {
  protected $table = 'lb_blocks';

  protected $casts = [
    'title' => 'array',
    'content' => 'array'
  ];

  protected const permitted = ['title', 'content', 'status'];
  protected $fillable = self::permitted;

  /**
   * Creates a block instance with the provided data
   * @param array $data - The content of the body sent by the Gutenberg editor
   * @return Block
   */
  public static function create($data) {
    $params = self::permittedParams($data);
    $block = new Block;
    $block->title = $params['title'];
    $block->content = $params['content'];
    $block->status = $params['status'];
    $block->updateSlug();
    return $block;
  } 

  /**
   * Updates slug according to title
   */
  public function updateSlug() {
    $this->slug = $this->title['raw'];
  }

  /**
   * Returns only the permitted parameters for given data
   * @param array $data
   * @return array
   */
  public static function permittedParams($data) {
    $permitted = self::permitted;
    return array_filter($data,  function($key) use ($permitted) {
      return in_array($key, $permitted);
    }, ARRAY_FILTER_USE_KEY);
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