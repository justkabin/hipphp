<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_listModels($params) {
    $offset = getInput("offset");
    if (!$offset) {
        $offset = 0;
    }
    $defaults = [
        "type" => NULL,
        "wheres" => NULL,
        "wheres_operand" => "AND",
        "limit" => 10,
        "count" => false,
        "order_by" => false,
        "order_by_reverse" => false
    ];
    $params = array_merge($defaults, $params);
    echo listModels($params);
}
