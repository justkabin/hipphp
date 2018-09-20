<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class ResendEmailVerificationActionHandler {

    public function __construct() {
        runHook("send_verification_email:before");

        $guid = getInput("guid");
        $user = getModel($guid);

        classGateKeeper($user, "User");

        if ($user->verified == "true") {
            forward();
        }

        Email::sendVerificationEmail($user);

        runHook("send_verification_email:after");

        new SystemMessage(translate("system_message:verification_email_sent"));
        forward();
    }

}
