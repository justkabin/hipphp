<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class EnableAllPluginsActionHandler {

    public function __construct() {
        adminGateKeeper();

        Cache::clear();
        $plugins = Plugin::getAll();
        if ($plugins) {
            foreach ($plugins as $plugin) {
                $plugin->enable();
            }
            Cache::clear();
            new SystemMessage("All possible plugins have been enabled.");
        }

        setupComplete(false);
        forward();
    }

}
