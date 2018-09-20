<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_timeago($params) {
    $defaults = array(
        "timestamp" => time()
    );
    $params = array_merge($defaults, $params);
    echo view("output/timeago", array(
        "timestamp" => $params['timestamp']
    ));
}
