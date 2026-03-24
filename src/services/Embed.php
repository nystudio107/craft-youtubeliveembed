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
use nystudio107\youtubeliveembed\models\Settings;
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

    public const YOUTUBE_EMBED_URL = 'https://www.youtube.com/embed';
    public const YOUTUBE_CHAT_URL = 'https://www.youtube.com/live_chat';
    public const YOUTUBE_CHANNEL_URL='https://www.youtube.com/channel';

    // Properties
    // =========================================================================

    /**
     * Cached video ID for the current livestream (avoids multiple YouTube fetches per request)
     */
    private ?string $_videoId = null;
    private bool $_videoIdFetched = false;

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
        if (YoutubeLiveEmbed::$youtubeChannelId !== $channelId) {
            YoutubeLiveEmbed::$youtubeChannelId = $channelId;
            $this->_videoId = null;
            $this->_videoIdFetched = false;
        }
    }

    /**
     * Returns whether the stream is currently live
     *
     * @return bool
     */
    public function isLive(): bool
    {
        /** @var Settings $settings */
        $settings = YoutubeLiveEmbed::$plugin->getSettings();
        return $settings->isLive;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Returns the URL to the channel's live page (used to extract video ID)
     *
     * @return string
     */
    protected function getYoutubeChannelLiveUrl(): string
    {
        return self::YOUTUBE_CHANNEL_URL . '/' . YoutubeLiveEmbed::$youtubeChannelId . '/live';
    }

    /**
     * Returns the URL to the live video YouTube page
     *
     * @return string
     */
    protected function getYoutubeStreamUrl(): string
    {
        $videoId = $this->getCachedVideoId();
        if ($videoId) {
            return self::YOUTUBE_EMBED_URL . '/' . $videoId;
        }

        return '';
    }

    /**
     * Returns the URL to the live chat YouTube page
     *
     * @return string
     */
    protected function getYoutubeChatUrl(): string
    {
        $url = '';
        $videoId = $this->getCachedVideoId();
        if ($videoId) {
            $url = UrlHelper::urlWithParams(self::YOUTUBE_CHAT_URL, [
                'v' => $videoId,
                'embed_domain' => $this->getSiteDomain(),
            ]);
        }

        return $url;
    }

    /**
     * Returns the cached video ID, using Craft's cache to avoid fetching from YouTube on every request
     *
     * @return ?string
     */
    protected function getCachedVideoId(): ?string
    {
        if (!$this->_videoIdFetched) {
            $cacheKey = 'youtubelive_videoid_' . YoutubeLiveEmbed::$youtubeChannelId;
            $this->_videoId = Craft::$app->getCache()->getOrSet($cacheKey, function() {
                return $this->getVideoIdFromLiveStream();
            }, 120);
            $this->_videoIdFetched = true;
        }

        return $this->_videoId;
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
        $liveUrl = $this->getYoutubeChannelLiveUrl();

        // Use a browser User-Agent and timeout to avoid YouTube returning bot-restricted content
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36\r\n",
                'timeout' => 5,
            ],
        ]);
        $data = @file_get_contents($liveUrl, false, $context);

        if (!$data) {
            Craft::warning("Failed to fetch YouTube live page: {$liveUrl}", __METHOD__);
            return null;
        }

        if (preg_match('/<link\s+rel="canonical"\s+href="https:\/\/www\.youtube\.com\/watch\?v=([^"&]+)"/i', $data, $matches)
            && $this->isValidVideoId($matches[1])) {
            return $matches[1];
        }

        if (preg_match('/var\s+ytInitialPlayerResponse\s*=\s*(\{.*?\});\s*var\s+\w+\s*=/s', $data, $matches)) {
            $playerResponse = json_decode($matches[1], true);
            $videoId = $playerResponse['videoDetails']['videoId'] ?? null;
            if ($videoId && $this->isValidVideoId($videoId)) {
                return $videoId;
            }
        }

        if (preg_match('/var\s+ytInitialData\s*=\s*(\{.*?\});\s*<\/script>/s', $data, $matches)) {
            $initialData = json_decode($matches[1], true);
            $videoId = $initialData['currentVideoEndpoint']['watchEndpoint']['videoId'] ?? null;
            if ($videoId && $this->isValidVideoId($videoId)) {
                return $videoId;
            }
        }

        return null;
    }

    /**
     * Validates that a string is a valid YouTube video ID (11 alphanumeric/dash/underscore characters)
     *
     * @param string $videoId
     * @return bool
     */
    private function isValidVideoId(string $videoId): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9_-]{11}$/', $videoId);
    }
}