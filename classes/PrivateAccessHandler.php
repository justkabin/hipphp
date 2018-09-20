<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class PrivateAccessHandler {

    public function init($model) {
        if ($model->owner_guid == getLoggedInUserGuid()) {
            return true;
        }
        return false;
    }

}
