<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class NotfoundRouter extends Router {

    function __construct() {
        $this->html = view("pages/404");
    }

}
