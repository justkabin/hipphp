<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class MessageSentRouter extends Router {

    public function __construct() {
        $this->html = view("pages/message_sent");
    }

}
