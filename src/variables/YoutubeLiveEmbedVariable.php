<?php
/**
 * YouTube Live Embed plugin for Craft CMS 3.x
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed\variables;

use nystudio107\youtubeliveembed\YoutubeLiveEmbed;

use Craft;

/**
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     1.0.0
 */
class YoutubeLiveEmbedVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return string
     */
    public function embedStream(int $aspectRatioX = 16, int $aspectRatioY = 9): string
    {
        return YoutubeLiveEmbed::$plugin->embed->embedStream($aspectRatioX, $aspectRatioY);
    }

    /**
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return string
     */
    public function embedChat(int $aspectRatioX = 16, int $aspectRatioY = 9): string
    {
        return YoutubeLiveEmbed::$plugin->embed->embedChat($aspectRatioX, $aspectRatioY);
    }
}
