<?php

namespace MauriceWijnia\Laraberg\Database\Models;

use MauriceWijnia\Laraberg\Database\Models\Base;

class Page extends Base {
  protected $table = 'lb_pages';

  protected $casts = [
    'content' => 'array'
  ];

  protected const permitted = ['content'];
  protected $fillable = self::permitted;

    /**
   * Creates a page instance with the provided data
   * @param array $data - The content of the body sent by the Gutenberg editor
   * @return Page
   */
  public static function create($data) {
    error_log(print_r($data, TRUE));
    $params = self::permittedParams($data);
    error_log(print_r($params, TRUE));
    $page = new Page;
    $page->content = $params['content'];
    return $page;
  } 

  /**
   * Transform content to wordpress content object
   */
  function setContentAttribute($content) {
    $this->attributes['content'] = json_encode([ 'raw' => $content ]);
  }
}