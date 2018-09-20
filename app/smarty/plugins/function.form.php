<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_form($params, &$smarty) {
    $defaults = array(
        "name" => "",
        "method" => "post",
        "action" => "",
        "class" => ""
    );
    $params = array_merge($defaults, $params);
    $params = array_merge($params, smartyVars());
    echo drawForm($params);
}
