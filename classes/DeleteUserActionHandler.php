<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class DeleteUserActionHandler {

    public function __construct() {
        adminGateKeeper();
        $guid = pageArray(2);
        if ($guid) {
            $user = getModel($guid);
            // Prevent admin from deleting self
            if ($user->guid != getLoggedInUserGuid()) {
                $guid = $user->guid;
                $user->delete();
                runHook("delete_user", [
                    "user_guid" => $guid
                ]);
            }
        }
        forward();
    }

}
