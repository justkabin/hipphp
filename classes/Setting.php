<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Setting extends Model {

    public function __construct($params = array()) {
        if (!empty($params)) {
            $defaults = array(
                "name" => "",
                "input_type" => "text",
                "options" => array()
            );
            $params = array_merge($defaults, $params);
            $exists = getModel(array(
                "type" => "Setting",
                "wheres" => array(
                    array("name", "=", $params['name'])
                )
            ));
            if (!$exists) {
                $this->name = $params['name'];
                $this->input_type = $params['input_type'];
                $this->options = $params['options'];
                $this->save();
            }
        }
    }

    static function get($name) {
        $model = getModel([
            "type" => "Setting",
            "wheres" => [
                ["name", "=", $name]
            ]
        ]);
        if (is_object($model)) {
            return $model->value;
        }
    }

    static function set($name, $value) {
        $setting = getModel(array(
            "type" => "Setting",
            "wheres" => array(
                array("name", "=", $name)
            )
        ));
        if (!$setting) {
            $setting = new Setting;
            $setting->name = $name;
        }
        $setting->value = $value;
        $setting->save();
    }

}
