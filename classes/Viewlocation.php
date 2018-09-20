<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Viewlocation extends Model {

    public $system = true;

    public function __construct($viewName = null, $Viewlocation = null) {
        if ($viewName && $Viewlocation) {
            $test = getModel(array(
                "type" => "Viewlocation",
                "wheres" => array(
                    array("name", "=", $viewName)
                )
            ));
            if (!$test) {
                $this->name = $viewName;
                $this->location = $Viewlocation;
                $this->save();
            }
        }
    }

    public static function get($view) {
        $Viewlocation = getModel([
            "type" => "Viewlocation",
            "wheres" => [
                ["name", "=", $view]
            ]
        ]);
        if ($Viewlocation) {
            return $Viewlocation->location;
        }
        return null;
    }

    public function purgeAll() {
        $Viewlocations = getModels([
            "type" => "Viewlocation"
        ]);
        if ($Viewlocations) {
            foreach ($Viewlocations as $location) {
                $location->delete();
            }
        }
    }

    public static function viewExists($view) {
        $test = getModel([
            "type" => "Viewlocation",
            "wheres" => [
                ["name", "=", $view]
            ]
        ]);
        return $test ? true : false;
    }

}
