<?php

namespace MauriceWijnia\Laraberg\Http\Controllers;

use Illuminate\Http\Request;
use Embed\Embed;

class OEmbedController extends ApplicationController {
  public function __invoke(Request $request) {
    $embed = Embed::create($request->url);
    $data = $this->serializeEmbed($embed);
    if ($data['html'] == null) {
      return $this->notFound();
    }
    return $this->ok($data);
  }

  private function serializeEmbed($embed) {
    return [
      'url' => $embed->url,
      'author_name' => $embed->authorName,
      'author_url' => $embed->authorUrl,
      'html' => $embed->code,
      'width' => $embed->width,
      'height' => $embed->height,
      'type' => $embed->type,
      'provider_name' => $embed->providerName,
      'provider_url' => $embed->providerUrl
    ];
  }
}