<?php
/**
 * YouTube Live Embed plugin for Craft CMS
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed\variables;

use nystudio107\youtubeliveembed\YoutubeLiveEmbed;

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
     * Renders the responsive iframe for the live stream video
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return \Twig_Markup
     */
    public function embedStream(int $aspectRatioX = 16, int $aspectRatioY = 9): \Twig_Markup
    {
        return YoutubeLiveEmbed::$plugin->embed->embedStream($aspectRatioX, $aspectRatioY);
    }

    /**
     * Renders the responsive Google AMP iframe for the live stream video
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return \Twig_Markup
     */
    public function embedStreamAmp(int $aspectRatioX = 16, int $aspectRatioY = 9): \Twig_Markup
    {
        return YoutubeLiveEmbed::$plugin->embed->embedStreamAmp($aspectRatioX, $aspectRatioY);
    }

    /**
     * Renders the responsive iframe HTML for the live stream chat
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return \Twig_Markup
     */
    public function embedChat(int $aspectRatioX = 16, int $aspectRatioY = 9): \Twig_Markup
    {
        return YoutubeLiveEmbed::$plugin->embed->embedChat($aspectRatioX, $aspectRatioY);
    }

    /**
     * Renders the responsive Google AMP iframe HTML for the live stream chat
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return \Twig_Markup
     */
    public function embedChatAmp(int $aspectRatioX = 16, int $aspectRatioY = 9): \Twig_Markup
    {
        return YoutubeLiveEmbed::$plugin->embed->embedChatAmp($aspectRatioX, $aspectRatioY);
    }

    /**
     * Sets the YouTube Channel ID to $channelId
     *
     * @param string $channelId
     *
     * @return string
     */
    public function setChannelId(string $channelId): string
    {
        YoutubeLiveEmbed::$plugin->embed->setChannelId($channelId);

        return '';
    }

    /**
     * Returns whether the stream is currently live
     *
     * @return bool
     */
    public function isLive(): bool
    {
        return YoutubeLiveEmbed::$plugin->embed->isLive();
    }
}
