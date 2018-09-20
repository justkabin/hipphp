<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class HomeRouter extends Router {

    public function __construct() {
        $heading = null;
        $body = view("pages/home");
        $breadcrumbs = array(
            "breadcrumb:home" => getSiteURL()
        );
        $this->html = drawPage([
            "heading" => $heading,
            "body" => $body,
            "breadcrumbs" => $breadcrumbs
        ]);
    }

}
