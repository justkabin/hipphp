<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 *  User setting system.
 */
class Usersetting {

    /**
     * Create a new user setting.
     *
     * @param array $params     Array of paramaters
     *                          name=>name of setting,
     *                          field_type=>field type for input,
     *                          options=>array of options and values used if field_type is dropdown,
     *                          default_value=>default value if nothing returned
     *                          tab=>user setting tab
     */
    public function __construct($params) {
        $user_settings = Cache::get("user_settings", "session");
        if (!$user_settings) {
            $user_settings = [];
        }
        if (!isset($user_settings[$params['name']])) {
            $user_settings[$params['name']] = [
                "field_type" => $params['field_type'],
                "options" => $params['options'],
                "default_value" => $params['default_value'],
                "tab" => $params['tab']
            ];
            new Cache("user_settings", $user_settings, "session");
        }
    }

    static function listTabs() {
        $tabs = [];
        $user_settings = Cache::get("user_settings", "session");
        if (!$user_settings) {
            $user_settings = [];
        }
        foreach ($user_settings as $key => $value) {
            $tabs[] = $value['tab'];
        }
        return array_unique($tabs);
    }

}
