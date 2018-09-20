<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class PasswordResetEmailSentRouter extends Router {

    public function __construct() {
        $this->html = view("pages/password_reset_email_sent");
    }

}
