<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_input($params, &$smarty) {
    $defaults = array(
        "type" => "text"
    );
    $params = array_merge($defaults, $params);
    $type = $params['type'];
    unset($params['type']);
    echo view("input/$type", $params);
}
