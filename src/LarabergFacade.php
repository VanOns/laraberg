<?php

namespace mauricewijnia\Laraberg;

use Illuminate\Support\Facades\Facade;

class LarabergFacade extends Facade {
  protected static function getFacadeAccessor() {
    return 'laraberg';
  }
}