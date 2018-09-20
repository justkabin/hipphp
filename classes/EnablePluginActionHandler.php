<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class EnablePluginActionHandler {

    public function __construct() {
        $guid = pageArray(2);
        adminGateKeeper();
        $plugin = getModel($guid);

        clearCache();
        setupComplete(false);
        if ($plugin->enable()) {
            new SystemMessage("Plugin Enabled");
            forward();
        }

        new SystemMessage("Your plugin can't be enabled.  Check requirements");
        forward();
    }

}
