<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class DeleteModelActionHandler {

    function __construct() {
        $guid = pageArray(2);
        $model = getModel($guid);
        $type = $model->type;
        $model->delete();
        new SystemMessage("Your " . $type . " has been deleted.");
        forward();
    }

}
