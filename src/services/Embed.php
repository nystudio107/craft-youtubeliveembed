<?php
/**
 * YouTube Live Embed plugin for Craft CMS 3.x
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed\services;

use nystudio107\youtubeliveembed\YoutubeLiveEmbed;
use nystudio107\youtubeliveembed\helpers\PluginTemplate;

use Craft;
use craft\base\Component;
use craft\helpers\UrlHelper;

/** @noinspection MissingPropertyAnnotationsInspection */

/**
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     1.0.0
 */
class Embed extends Component
{
    // Constants
    // =========================================================================

    const YOUTUBE_STREAM_URL = 'https://www.youtube.com/embed/live_stream';
    const YOUTUBE_CHAT_URL = 'https://www.youtube.com/live_chat';
    const YOUTUBE_LIVE_STATS_URL = 'https://www.youtube.com/live_stats';

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
        $html = PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-stream.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeStreamUrl(),
            ]
        );

        return $html;
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
        $html = PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-stream-amp.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeStreamUrl(),
            ]
        );

        return $html;
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
        $html = PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-chat.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeChatUrl(),
            ]
        );

        return $html;
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
        $html = PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-chat-amp.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeChatUrl(),
            ]
        );

        return $html;
    }

    /**
     * Sets the YouTube Channel ID to $channelId
     *
     * @param string $channelId
     */
    public function setChannelId(string $channelId)
    {
        YoutubeLiveEmbed::$youtubeChannelId = $channelId;
    }

    /**
     * Returns whether the stream is currently live
     *
     * @return bool
     */
    public function isLive(): bool
    {
        return (bool)$this->liveViewers();
    }

    /**
     * Returns the number of people currently viewing the live stream
     *
     * @return int
     */
    public function liveViewers(): int
    {
        $count = 0;
        $videoId = $this->getVideoIdFromLiveStream();
        if ($videoId) {
            $liveUrl = UrlHelper::urlWithParams(self::YOUTUBE_LIVE_STATS_URL, [
                'v' => $this->getVideoIdFromLiveStream(),
            ]);
            // Fetch the livestream page
            if ($data = @file_get_contents($liveUrl)) {
                $count = (int)$data;
            }
        }

        return $count;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Returns the URL to the live video YouTube page
     *
     * @return string
     */
    protected function getYoutubeStreamUrl(): string
    {
        $url =  UrlHelper::urlWithParams(self::YOUTUBE_STREAM_URL, [
            'channel' => YoutubeLiveEmbed::$youtubeChannelId,
        ]);

        return $url;
    }

    /**
     * Returns the URL to the live chat YouTube page
     *
     * @return string
     */
    protected function getYoutubeChatUrl(): string
    {
        $url = '';
        $videoId = $this->getVideoIdFromLiveStream();
        if ($videoId) {
            $site = Craft::$app->getSites()->currentSite;
            $domain = parse_url($site->baseUrl, PHP_URL_HOST);
            $url = UrlHelper::urlWithParams(self::YOUTUBE_CHAT_URL, [
                'v' => $this->getVideoIdFromLiveStream(),
                'embed_domain' => $domain
            ]);
        }

        return $url;
    }

    /**
     * Extracts the Video ID of the current live stream video
     *
     * @return null|string
     */
    protected function getVideoIdFromLiveStream()
    {
        $videoId = null;
        $liveUrl = $this->getYoutubeStreamUrl();
        // Fetch the livestream page
        if ($data = @file_get_contents($liveUrl)) {
            // Find the video ID in there
            if (preg_match('/\'VIDEO_ID\': \"(.*?)\"/', $data, $matches)) {
                $videoId = $matches[1];
            }
        }

        return $videoId;
    }
}
