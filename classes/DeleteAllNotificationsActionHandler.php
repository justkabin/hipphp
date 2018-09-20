<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class DeleteAllNotificationsActionHandler {

    public function __construct() {
        $guid = pageArray(2);
        if (getLoggedInUserGuid() == $guid) {
            $notifications = getModels([
                "type" => "Notification",
                "wheres" => [
                    [
                        "owner_guid", "=", $guid
                    ]
                ],
            ]);
            if ($notifications) {
                foreach ($notifications as $notification) {
                    $notification->delete();
                }
            }
        }
        forward();
    }

}
