<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class LoginRouter extends Router {

    public function __construct() {
        $this->html = view('pages/login');
    }

}
