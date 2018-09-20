<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Access handler system
 */
class Accesshandler extends Model {

    public $type = "Accesshandler";
    public $system = true;

    public function __construct($handler = false) {
        if ($handler) {
            $test = getModel(array(
                "type" => "Accesshandler",
                "wheres" => array(
                    array("hander", "=", $handler)
                )
            ));
            if (!$handler) {
                $this->access_id = "system";
                $this->handler = $handler;
                $this->save();
            }
        }
    }

}
