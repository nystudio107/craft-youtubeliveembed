<?php
/**
 * YouTube Live Embed plugin for Craft CMS 3.x
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed\controllers;

use nystudio107\youtubeliveembed\YoutubeLiveEmbed;

use Craft;
use craft\web\Controller;

/**
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     1.0.9
 */
class StreamController extends Controller
{
    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = [
        'update-stream-status',
    ];

    // Public Methods
    // =========================================================================


    /**
     * Toggles the stream to live or offline in plugin
     *
     *
     */
    public function actionUpdateStreamStatus($yttoken = '')
    {
        $streamIsLive = YoutubeLiveEmbed::$plugin->embed->isLive();
        $myPlugin = Craft::$app->plugins->getPlugin( 'youtubeliveembed' );

        if (YoutubeLiveEmbed::$plugin->embed->isLive()) {
            $settings = array('isLive' => false);
        }
        else {
            $settings = array('isLive' => true);
        }
        if ( YoutubeLiveEmbed::$plugin->embed->getToken() == $yttoken) {
            return Craft::$app->plugins->savePluginSettings( $myPlugin, $settings );
        }
    }
}
