<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class PagesRouter extends Router {

    function __construct() {

        switch (pageArray(1)) {
            case "add":
                $header = "Add a page.";
                $body = drawForm([
                    "name" => "addPage",
                    "method" => "post",
                    "action" => "AddPage"
                ]);
                break;
            default:
                $guid = pageArray(1);
                $page = getModel($guid);
                $header = $page->label;
                $body = "<div class='inline-editor' data-guid='$guid'>$page->description</div>";
                break;
        }

        $this->html = drawPage([
            "heading" => $header,
            "body" => $body
        ]);
    }

}
