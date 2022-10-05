<?php
/**
 * YouTube Live Embed plugin for Craft CMS
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2022 nystudio107
 */

namespace nystudio107\youtubeliveembed\services;

use nystudio107\youtubeliveembed\services\Embed as EmbedService;
use yii\base\InvalidConfigException;

/**
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     4.0.0
 *
 * @property  EmbedService $embed
 */
trait ServicesTrait
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function config(): array
    {
        return [
            'components' => [
                'embed' => EmbedService::class,
            ]
        ];
    }

    /**
     * Returns the embed service
     *
     * @return EmbedService The embed service
     * @throws InvalidConfigException
     */
    public function getEmbed(): EmbedService
    {
        return $this->get('embed');
    }
}
