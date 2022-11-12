<?php
/**
 * YouTube Live Embed plugin for Craft CMS
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use nystudio107\youtubeliveembed\models\Settings;
use nystudio107\youtubeliveembed\services\ServicesTrait;
use nystudio107\youtubeliveembed\variables\YoutubeLiveEmbedVariable;
use yii\base\Event;

/**
 * Class YoutubeLiveEmbed
 *
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     1.0.0
 */
class YoutubeLiveEmbed extends Plugin
{
    // Traits
    // =========================================================================

    use ServicesTrait;

    // Static Properties
    // =========================================================================

    /**
     * @var YoutubeLiveEmbed
     */
    public static $plugin;

    /**
     * @var string
     */
    public static $youtubeChannelId;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSection = false;

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        self::$youtubeChannelId = $this->getSettings()->youtubeChannelId;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('youtubelive', YoutubeLiveEmbedVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'youtubeliveembed',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'youtubeliveembed/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
