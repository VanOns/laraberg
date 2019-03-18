<?php

namespace VanOns\Laraberg\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class ApplicationController extends BaseController
{
    public function ok($data = ['message' => 'ok'], $code = 200)
    {
        return $this->response($data, $code);
    }

    public function notFound($code = 404)
    {
        return $this->response(['message' => 'not_found'], $code);
    }

    public function response($data, $code)
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }
}

