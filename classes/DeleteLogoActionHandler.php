<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class DeleteLogoActionHandler {

    function __construct() {
        adminGateKeeper();
        $logo = getModel([
            "type" => "Logo"
        ]);
        if ($logo) {
            $logo->delete();
        }
        new SystemMessage("Your logo has been removed.");
        forward();
    }

}
