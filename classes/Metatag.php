<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Metatag system
 */
class Metatag extends Model {

    public $system = true;

    /**
     * Creates a metatag object
     *
     * @param string $name      Name of metatag
     * @param string $type      Type of metatag (title, description)
     * @param type $value       Value of metatag type.
     */
    public function __construct($name = false, $type = "title", $value = NULL) {
        if ($name) {
            $test = getModel([
                "type" => "Metatag",
                "wheres" => [
                    ["metatag_name", "=", $name],
                    ["metatag_type", "=", $type]
                ]
            ]);
            if (!$test) {
                $this->access_id = "system";
                $this->metatag_name = $name;
                $this->metatag_type = $type;
                $this->metatag_value = $value;
                $this->save();
            }
        }
    }

    static function update($name = false, $type = false, $value = false) {
        $metatag = getModel([
            "type" => "Metatag",
            "wheres" => [
                ["metatag_name", "=", $name],
                ["metatag_type", "=", $type]
            ]
        ]);
        if ($metatag) {
            $metatag->value = $value;
            $metatag->save();
        }
    }

    /**
     * Returns a metatag object
     *
     * @param string $name  Name of metatag to retrieve
     * @param type $type    Type of metatag to retrieve
     * @return mixed        Metatag object, or false
     */
    static function get($name = false, $type = false) {
        $params = [
            "type" => "Metatag",
            "wheres" => [
                ["metatag_name", "=", $name],
                ["metatag_type", "=", $type]
            ]
        ];
        if ($name && $type) {
            return getModel($params);
        } else {
            unset($params['wheres']);
            return getModels($params);
        }
    }

    static function getMetatagText($type, $name) {
        $params = [
            "type" => "Metatag",
            "wheres" => [
                ["metatag_name", "=", $name],
                ["metatag_type", "=", $type]
            ]
        ];
        $metatag = getModel($params);
        if (!$metatag) {
            if ($type == "title") {
                return getSiteName();
            }
            if ($type == "description") {
                return null;
            }
            return false;
        }
        if (isset($metatag->metatag_value)) {
            return $metatag->metatag_value;
        } else {
            return NULL;
        }
    }

}
