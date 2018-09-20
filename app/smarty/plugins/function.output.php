<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_output($params, &$smarty) {
    $defaults = array(
        "type" => "text"
    );
    $params = array_merge($defaults, $params);
    $type = $params['type'];
    unset($params['type']);
    echo view("output/$type", $params);
}
