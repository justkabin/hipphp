<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_countModels($params, &$smarty) {
    $defaults = [
        "type" => NULL,
        "wheres" => NULL,
        "wheres_operand" => "AND",
        "limit" => false,
        "count" => true
    ];
    $params = array_merge($defaults, $params);
    $results = getModels($params);
    echo $results;
}
