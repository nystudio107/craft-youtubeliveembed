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

use craft\helpers\ArrayHelper;
use nystudio107\youtubeliveembed\services\Embed as EmbedService;
use yii\base\InvalidConfigException;

/**
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     1.0.6
 *
 * @property  EmbedService $embed
 */
trait ServicesTrait
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        // Merge in the passed config, so it our config can be overridden by Plugins::pluginConfigs['vite']
        // ref: https://github.com/craftcms/cms/issues/1989
        $config = ArrayHelper::merge([
            'components' => [
                'embed' => EmbedService::class,
            ]
        ], $config);

        parent::__construct($id, $parent, $config);
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
