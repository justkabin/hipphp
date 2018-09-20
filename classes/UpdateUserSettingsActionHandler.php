<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class UpdateUserSettingsActionHandler {

    public function __construct() {
        gateKeeper();
        $tab = getInput("tab");
        $settings = Cache::get("user_settings", "session");
        if (!$settings) {
            $settings = [];
        }
        $user = getLoggedInUser();
        foreach ($settings as $name => $setting) {
            if ($setting['tab'] == $tab) {
                $user->$name = getInput($name);
            }
        }
        $user->save();
        new SystemMessage("Your preferences have been saved.");
        forward();
    }

}
