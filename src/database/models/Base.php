<?php

namespace MauriceWijnia\Laraberg\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model {
  protected const permitted = [];

    /**
   * Returns only the permitted parameters for given data
   * @param array $data
   * @return array
   */
  public static function permittedParams($data) {
    $permitted = static::permitted;
    return array_filter($data,  function($key) use ($permitted) {
      return in_array($key, $permitted);
    }, ARRAY_FILTER_USE_KEY);
  }
}