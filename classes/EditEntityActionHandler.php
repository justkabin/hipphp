<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class EditModelActionHandler {

    function __construct() {
        $guid = getInput("guid");
        $model = getModel($guid);
        $fields = $model->fields();
        if (!empty($fields)) {
            foreach ($fields as $key => $attrs) {
                $model->$key = getInput($key);
            }
            $model->save();
        }
        $model->access_id = getInput("access_id");
        new SystemMessage("Your " . $model->type . " has been updated.");
        forward($model->type);
    }

}
