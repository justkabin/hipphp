<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class UpdateSEOValueActionHandler {

    public function __construct() {
        adminGateKeeper();
        $guid = getInput("guid");
        $model = getModel($guid);
        $title = getInput("title");
        $description = getInput("description");
        if ($title) {
            $model->metatag_value = $title;
        }
        if ($description) {
            $model->metatag_value = $description;
        }
        $model->save();
        forward();
    }

}
