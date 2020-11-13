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
        'is-live',
    ];

    // Public Methods
    // =========================================================================


    /**
     * Toggles the stream to live or offline in plugin
     *
     *
     */
    public function actionUpdateStreamStatus()
    {
        $streamIsLive = YoutubeLiveEmbed::$plugin->embed->isLive();

        if ($streamIsLive) {
            // turn it off
            YoutubeLiveEmbed::$plugin->setStreamStatus(false);
        }
        elseif (!$streamIsLive) {
            // turn it on
            YoutubeLiveEmbed::$plugin->setStreamStatus(true);
        }


    }
}
