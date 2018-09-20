<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class GeneralSettingsActionHandler {

    public function __construct() {
        $access = getIgnoreAccess();
        setIgnoreAccess();
        $system_settings = getModels([
            "type" => "Setting"
        ]);
        setIgnoreAccess($access);
        if ($system_settings) {
            foreach ($system_settings as $setting) {
                $name = $setting->name;
                $value = getInput($name);
                $setting->value = $value;
                $setting->save();
            }
        }
        clearCache();
        new SystemMessage("Your settings have been updated.");
        forward("admin/general");
    }

}
