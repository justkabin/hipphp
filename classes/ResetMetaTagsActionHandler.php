<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class ResetMetatagsActionHandler {

    public function __construct() {
        adminGateKeeper();
        $metatags = getModels([
            "type" => "Metatag"
        ]);
        foreach ($metatags as $metatag) {
            $metatag->delete();
        }
        Setting::set("setup_complete", "false");
        new SystemMessage("Default values have been loaded.");
        forward();
    }

}
