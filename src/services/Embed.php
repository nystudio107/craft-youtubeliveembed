<?php
/**
 * YouTube Live Embed plugin for Craft CMS
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed\services;

use Craft;
use craft\base\Component;
use craft\helpers\UrlHelper;
use nystudio107\youtubeliveembed\helpers\PluginTemplate;
use nystudio107\youtubeliveembed\YoutubeLiveEmbed;
use Twig\Markup;

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

    public const YOUTUBE_STREAM_URL = 'https://www.youtube.com/embed/live_stream';
    public const YOUTUBE_CHAT_URL = 'https://www.youtube.com/live_chat';

    // Public Methods
    // =========================================================================
    /**
     * Renders the responsive iframe for the live stream video
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return Markup
     */
    public function embedStream(int $aspectRatioX = 16, int $aspectRatioY = 9): Markup
    {
        return PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-stream.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeStreamUrl(),
            ]
        );
    }

    /**
     * Renders the responsive Google AMP iframe for the live stream video
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return Markup
     */
    public function embedStreamAmp(int $aspectRatioX = 16, int $aspectRatioY = 9): Markup
    {
        return PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-stream-amp.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeStreamUrl(),
            ]
        );
    }

    /**
     * Renders the responsive iframe HTML for the live stream chat
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return Markup
     */
    public function embedChat(int $aspectRatioX = 16, int $aspectRatioY = 9): Markup
    {
        return PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-chat.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeChatUrl(),
                'embedDomain' => $this->getSiteDomain(),
            ]
        );
    }

    /**
     * Renders the responsive Google AMP iframe HTML for the live stream chat
     *
     * @param int $aspectRatioX
     * @param int $aspectRatioY
     *
     * @return Markup
     */
    public function embedChatAmp(int $aspectRatioX = 16, int $aspectRatioY = 9): Markup
    {
        return PluginTemplate::renderPluginTemplate(
            'embeds/youtube-live-chat-amp.twig',
            [
                'aspectRatio' => ($aspectRatioY / $aspectRatioX) * 100,
                'iframeUrl' => $this->getYoutubeChatUrl(),
                'embedDomain' => $this->getSiteDomain(),
            ]
        );
    }

    /**
     * Sets the YouTube Channel ID to $channelId
     *
     * @param string $channelId
     */
    public function setChannelId(string $channelId): void
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
        return YoutubeLiveEmbed::$plugin->getSettings()->isLive;
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
        return UrlHelper::urlWithParams(self::YOUTUBE_STREAM_URL, [
            'channel' => YoutubeLiveEmbed::$youtubeChannelId,
        ]);
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
            $url = UrlHelper::urlWithParams(self::YOUTUBE_CHAT_URL, [
                'v' => $this->getVideoIdFromLiveStream(),
                'embed_domain' => $this->getSiteDomain(),
            ]);
        }

        return $url;
    }


    /**
     * Returns the domain of the host site
     *
     * @return string
     */
    protected function getSiteDomain(): string
    {
        $site = Craft::$app->getSites()->currentSite;
        $request = Craft::$app->getRequest();
        $domain = parse_url($site->getBaseUrl(), PHP_URL_HOST);

        return $domain ?? $request->getHostName();
    }

    /**
     * Extracts the Video ID of the current live stream video
     *
     * @return ?string
     */
    protected function getVideoIdFromLiveStream(): ?string
    {
        $videoId = null;
        $liveUrl = $this->getYoutubeStreamUrl();
        // Fetch the livestream page
        // Find the video ID in there
        if (($data = @file_get_contents($liveUrl)) && preg_match('/\"VIDEO_ID\":\"(.*?)\"/', $data, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId;
    }
}
