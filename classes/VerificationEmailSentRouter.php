<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class VerificationEmailSentRouter extends Router {

    public function __construct() {
        $guid = pageArray(1);
        $this->html = view("pages/verification_email_sent", [
            "guid" => $guid
        ]);
    }

}
