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

use craft\helpers\UrlHelper;
use nystudio107\youtubeliveembed\YoutubeLiveEmbed;
use nystudio107\youtubeliveembed\helpers\PluginTemplate;

use Craft;
use craft\base\Component;

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
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return string
     */
    public function embedChat(int $aspectRatioX = 16, int $aspectRatioY = 9): string
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

    // Protected Methods
    // =========================================================================

    /**
     * @return string
     */
    protected function getYoutubeStreamUrl(): string
    {
        $html =  UrlHelper::urlWithParams(self::YOUTUBE_STREAM_URL, [
            'channel' => YoutubeLiveEmbed::$plugin->getSettings()->youtubeChannelId,
        ]);

        return $html;
    }

    /**
     * @return string
     */
    protected function getYoutubeChatUrl(): string
    {
        $html = '';
        $videoId = $this->getVideoIdFromLiveStream();
        if ($videoId) {
            $site = Craft::$app->getSites()->currentSite;
            $domain = parse_url($site->baseUrl, PHP_URL_HOST);
            $html = UrlHelper::urlWithParams(self::YOUTUBE_CHAT_URL, [
                'v' => $this->getVideoIdFromLiveStream(),
                'embed_domain' => $domain
            ]);
        }

        return $html;
    }

    /**
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
