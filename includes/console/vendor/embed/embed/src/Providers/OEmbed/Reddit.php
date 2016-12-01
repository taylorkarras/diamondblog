<?php

namespace Embed\Providers\OEmbed;

use Embed\Url;

class Reddit extends OEmbedImplementation
{
    /**
     * {@inheritdoc}
     */
    public static function getEndPoint(Url $url)
    {
        return 'https://www.reddit.com/oembed';
    }

    /**
     * {@inheritdoc}
     */
    public static function getPatterns()
    {
        return [
            'https?://www.reddit.com/r/*',
        ];
    }
}
