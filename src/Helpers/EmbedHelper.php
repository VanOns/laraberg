<?php

namespace VanOns\Laraberg\Helpers;

use Embed\Embed;

class EmbedHelper
{

    /**
     * Renders any embeds in the HTML
     * @param String $html
     * @return String - The HTML containing all embed code
     */
    public static function renderEmbeds($html)
    {
        // Match URL from raw Gutenberg embed content
        $regex = '/<!-- wp:core-embed\/.*?-->\s*?<figure class="wp-block-embed.*?".*?<div class="wp-block-embed__wrapper">\s*?(.*?)\s*?<\/div>.*?<\/figure>/';
        $result = preg_replace_callback($regex, function ($matches) {
            $embed = self::create($matches[1]);
            $url = preg_replace('/\//', '\/', preg_quote($matches[1]));
            // Replace URL with OEmbed HTML
            return preg_replace("/>\s*?$url\s*?</", ">$embed->code<", $matches[0]);
        }, $html);
        return $result;
    }

    /**
     * Transforms the Embed/Embed object to a format that Gutenberg can handle
     * @param Embed $embed
     * @return array
     */
    public static function serialize($embed) {
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

    /**
     * Creates an embed from a URL
     * @param String $url
     */
    public static function create($url)
    {
        return Embed::create($url);
    }
}

