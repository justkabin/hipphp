<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_footerInit() {
    $scripts = null;
    $footer_js_names = FooterJS::getFooterJSNameArray();
    foreach ($footer_js_names as $name) {
        $scripts .= $name . ".init();" . "\n\r";
    }
    echo $scripts;
}
