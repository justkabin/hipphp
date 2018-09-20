<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class VerifyEmailActionHandler {

    public function __construct() {
        if (!pageArray(2) || !pageArray(3)) {
            return false;
        }
        $email = pageArray(2);
        $code = pageArray(3);

        runHook("action:verify_email:before");

        $access = getIgnoreAccess();
        setIgnoreAccess();
        $user = getModels(
                [
                    "type" => "User",
                    "wheres" => [
                        ["email", "=", $email],
                        ["email_verification_code", "=", $code]
                    ],
                ]
        );

        setIgnoreAccess($access);
        if (!$user) {
            new SystemMessage(translate("system_message:email_could_not_be_verified"));
            forward();
        }
        $user = $user[0];
        $user->email_verification_code = NULL;
        $user->verified = "true";
        $user->save();

        runHook("action:verify_email:after");

        new SystemMessage(translate("system_message:email_verified"));
        new Activity("joined", $user->guid);
        forward("login");
    }

}
