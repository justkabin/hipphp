<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_view($params, &$smarty) {
    $defaults = array(
        "name" => "",
        "extend" => false
    );
    $params = array_merge($defaults, $params);
    $extend = $params['extend'];
    unset($params['extend']);
    $name = $params['name'];
    unset($params['name']);
    $params = array_merge($params, $smarty->getTemplateVars());
    $unset = array(
        "SCRIPT_NAME",
        "path"
    );
    foreach ($unset as $key => $u) {
        unset($params[$u]);
    }
    return view($name, $params, $extend);
}
