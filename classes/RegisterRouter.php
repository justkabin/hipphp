<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class RegisterRouter extends Router {

    public function __construct() {
        $this->html = view("pages/register");
    }

}
