<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class ResetSettingsActionHandler {

    public function __construct() {
        adminGateKeeper();
        $settings = getModels([
            "type" => "Setting"
        ]);
        foreach ($settings as $setting) {
            $setting->delete();
        }
        Setting::set("setup_complete", "false");
        clearCache();
        Cache::clear();
        new SystemMessage("All settings have been reset.");
        forward();
    }

}
