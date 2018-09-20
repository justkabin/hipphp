<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Email System
 */
class Email {

    public function __construct($params) {
        sendEmail($params);
    }

}
