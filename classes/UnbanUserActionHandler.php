<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class UnbanUserActionHandler {

    function __construct() {
        adminGateKeeper();
        $guid = pageArray(2);
        $user = getModel($guid);
        $user->banned = "false";
        $user->save();
        new SystemMessage("You have successfully unbanned a user.");
        forward();
    }

}
