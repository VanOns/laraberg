<?php

namespace VanOns\Laraberg\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use VanOns\Laraberg\Exceptions\OEmbedFetchException;

class OEmbedService
{
    const FORMATS = ['json', 'xml'];

    /**
     * Get OEmbed data from a URL
     *
     * @param string $url
     * @return array|null
     * @throws OEmbedFetchException
     */
    public function parse(string $url): ?array
    {
        $cache = config('laraberg.embed.cache.enabled', true);
        $key = "laraberg_embed_parse_{$url}";

        if ($cache && $cached = Cache::get($key)) {
            return $cached;
        }

        $data = $this->fetch(
            $this->getEndpointUrl($url),
            compact('url')
        );

        if ($cache) {
            Cache::set($key, $data, config('laraberg.embed.cache.duration', 3600));
        }

        return $data;
    }

    /**
     * Get default args for OEmbed requests
     *
     * @return array
     */
    protected function defaultArgs(): array
    {
        $maxwidth = intval(config('laraberg.embed.maxwidth', 1000));
        $maxheight = intval(config('laraberg.embed.maxheight', min($maxwidth * 1.5, 1000)));
        $dnt = 1;

        return compact('maxwidth', 'maxheight', 'dnt');
    }

    /**
     * Fetch OEmbed data for a url and args
     *
     * @throws OEmbedFetchException
     */
    protected function fetch(string $url, array $args): array
    {
        $data = null;

        foreach (static::FORMATS as $format) {
            $res = Http::get(
                str_replace('{format}', $format, $url),
                array_merge($this->defaultArgs(), ['format' => $format], $args)
            );

            if ($res->status() === 200) {
                $data = $res->json();
                break;
            }
        }

        if (!is_array($data)) {
            throw new OEmbedFetchException();
        }

        return $data;
    }

    /**
     * Get the OEmbed endpoint for a URL
     *
     * @param string $url
     * @return string|null
     */
    protected function getEndpointUrl(string $url): ?string
    {
        $first = Arr::first($this->getProviders(), function ($arr, $regex) use ($url) {
            return preg_match($regex, $url);
        });

        return $first[0] ?? null;
    }

    /**
     * Get all OEmbed providers
     * Taken from: https://github.com/WordPress/WordPress/blob/master/wp-includes/class-wp-oembed.php
     *
     * @return array[]
     */
    protected function getProviders(): array
    {
        $host = config('app.url');

        return [
            '#https?://((m|www)\.)?youtube\.com/watch.*#i' => ['https://www.youtube.com/oembed', true],
            '#https?://((m|www)\.)?youtube\.com/playlist.*#i' => ['https://www.youtube.com/oembed', true],
            '#https?://youtu\.be/.*#i'                     => ['https://www.youtube.com/oembed', true],
            '#https?://(.+\.)?vimeo\.com/.*#i'             => ['https://vimeo.com/api/oembed.{format}', true],
            '#https?://(www\.)?dailymotion\.com/.*#i'      => ['https://www.dailymotion.com/services/oembed', true],
            '#https?://dai\.ly/.*#i'                       => ['https://www.dailymotion.com/services/oembed', true],
            '#https?://(www\.)?flickr\.com/.*#i'           => ['https://www.flickr.com/services/oembed/', true],
            '#https?://flic\.kr/.*#i'                      => ['https://www.flickr.com/services/oembed/', true],
            '#https?://(.+\.)?smugmug\.com/.*#i'           => ['https://api.smugmug.com/services/oembed/', true],
            '#https?://(www\.)?scribd\.com/(doc|document)/.*#i' => ['https://www.scribd.com/services/oembed', true],
            '#https?://wordpress\.tv/.*#i'                 => ['https://wordpress.tv/oembed/', true],
            '#https?://(.+\.)?polldaddy\.com/.*#i'         => ['https://api.crowdsignal.com/oembed', true],
            '#https?://poll\.fm/.*#i'                      => ['https://api.crowdsignal.com/oembed', true],
            '#https?://(.+\.)?survey\.fm/.*#i'             => ['https://api.crowdsignal.com/oembed', true],
            '#https?://(www\.)?twitter\.com/\w{1,15}/status(es)?/.*#i' => ['https://publish.twitter.com/oembed', true],
            '#https?://(www\.)?twitter\.com/\w{1,15}$#i'   => ['https://publish.twitter.com/oembed', true],
            '#https?://(www\.)?twitter\.com/\w{1,15}/likes$#i' => ['https://publish.twitter.com/oembed', true],
            '#https?://(www\.)?twitter\.com/\w{1,15}/lists/.*#i' => ['https://publish.twitter.com/oembed', true],
            '#https?://(www\.)?twitter\.com/\w{1,15}/timelines/.*#i' => ['https://publish.twitter.com/oembed', true],
            '#https?://(www\.)?twitter\.com/i/moments/.*#i' => ['https://publish.twitter.com/oembed', true],
            '#https?://(www\.)?soundcloud\.com/.*#i'       => ['https://soundcloud.com/oembed', true],
            '#https?://(.+?\.)?slideshare\.net/.*#i'       => ['https://www.slideshare.net/api/oembed/2', true],
            '#https?://(open|play)\.spotify\.com/.*#i'     => ['https://embed.spotify.com/oembed/', true],
            '#https?://(.+\.)?imgur\.com/.*#i'             => ['https://api.imgur.com/oembed', true],
            '#https?://(www\.)?meetu(\.ps|p\.com)/.*#i'    => ['https://api.meetup.com/oembed', true],
            '#https?://(www\.)?issuu\.com/.+/docs/.+#i'    => ['https://issuu.com/oembed_wp', true],
            '#https?://(www\.)?mixcloud\.com/.*#i'         => ['https://www.mixcloud.com/oembed', true],
            '#https?://(www\.|embed\.)?ted\.com/talks/.*#i' => ['https://www.ted.com/services/v1/oembed.{format}', true],
            '#https?://(www\.)?(animoto|video214)\.com/play/.*#i' => ['https://animoto.com/oembeds/create', true],
            '#https?://(.+)\.tumblr\.com/post/.*#i'        => ['https://www.tumblr.com/oembed/1.0', true],
            '#https?://(www\.)?kickstarter\.com/projects/.*#i' => ['https://www.kickstarter.com/services/oembed', true],
            '#https?://kck\.st/.*#i'                       => ['https://www.kickstarter.com/services/oembed', true],
            '#https?://cloudup\.com/.*#i'                  => ['https://cloudup.com/oembed', true],
            '#https?://(www\.)?reverbnation\.com/.*#i'     => ['https://www.reverbnation.com/oembed', true],
            '#https?://videopress\.com/v/.*#'              => ['https://public-api.wordpress.com/oembed/?for=' . $host, true],
            '#https?://(www\.)?reddit\.com/r/[^/]+/comments/.*#i' => ['https://www.reddit.com/oembed', true],
            '#https?://(www\.)?speakerdeck\.com/.*#i'      => ['https://speakerdeck.com/oembed.{format}', true],
            '#https?://(www\.)?screencast\.com/.*#i'       => ['https://api.screencast.com/external/oembed', true],
            '#https?://([a-z0-9-]+\.)?amazon\.(com|com\.mx|com\.br|ca)/.*#i' => ['https://read.amazon.com/kp/api/oembed', true],
            '#https?://([a-z0-9-]+\.)?amazon\.(co\.uk|de|fr|it|es|in|nl|ru)/.*#i' => ['https://read.amazon.co.uk/kp/api/oembed', true],
            '#https?://([a-z0-9-]+\.)?amazon\.(co\.jp|com\.au)/.*#i' => ['https://read.amazon.com.au/kp/api/oembed', true],
            '#https?://([a-z0-9-]+\.)?amazon\.cn/.*#i'     => ['https://read.amazon.cn/kp/api/oembed', true],
            '#https?://(www\.)?a\.co/.*#i'                 => ['https://read.amazon.com/kp/api/oembed', true],
            '#https?://(www\.)?amzn\.to/.*#i'              => ['https://read.amazon.com/kp/api/oembed', true],
            '#https?://(www\.)?amzn\.eu/.*#i'              => ['https://read.amazon.co.uk/kp/api/oembed', true],
            '#https?://(www\.)?amzn\.in/.*#i'              => ['https://read.amazon.in/kp/api/oembed', true],
            '#https?://(www\.)?amzn\.asia/.*#i'            => ['https://read.amazon.com.au/kp/api/oembed', true],
            '#https?://(www\.)?z\.cn/.*#i'                 => ['https://read.amazon.cn/kp/api/oembed', true],
            '#https?://www\.someecards\.com/.+-cards/.+#i' => ['https://www.someecards.com/v2/oembed/', true],
            '#https?://www\.someecards\.com/usercards/viewcard/.+#i' => ['https://www.someecards.com/v2/oembed/', true],
            '#https?://some\.ly\/.+#i'                     => ['https://www.someecards.com/v2/oembed/', true],
            '#https?://(www\.)?tiktok\.com/.*/video/.*#i'  => ['https://www.tiktok.com/oembed', true],
        ];
    }
}
