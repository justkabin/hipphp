<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function arrayToArgs($array) {
    $return = NULL;
    if (empty($array)) {
        return NULL;
    }
    foreach ($array as $key => $value) {
        if ($value && !is_object($value)) {
            $return .= "$key = '$value' ";
        }
    }
    return $return;
}

function isAssoc($array) {
    if (is_array($array)) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    } else {
        return false;
    }
}

function randString($length, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count - 1)];
    }
    return $str;
}

function isSerialized($data, $strict = true) {
    // if it isn't a string, it isn't serialized.
    if (!is_string($data)) {
        return false;
    }
    $data = trim($data);
    if ('N;' == $data) {
        return true;
    }
    if (strlen($data) < 4) {
        return false;
    }
    if (':' !== $data[1]) {
        return false;
    }
    if ($strict) {
        $lastc = substr($data, -1);
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
    } else {
        $semicolon = strpos($data, ';');
        $brace = strpos($data, '}');
        // Either ; or } must exist.
        if (false === $semicolon && false === $brace) {
            return false;
        }
        // But neither must be in the first X characters.
        if (false !== $semicolon && $semicolon < 3) {
            return false;
        }
        if (false !== $brace && $brace < 4) {
            return false;
        }
    }
    $token = $data[0];
    switch ($token) {
        case 's' :
            if ($strict) {
                if ('"' !== substr($data, -2, 1)) {
                    return false;
                }
            } elseif (false === strpos($data, '"')) {
                return false;
            }
        // or else fall through
        case 'a' :
        case 'O' :
            return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
        case 'b' :
        case 'i' :
        case 'd' :
            $end = $strict ? '$' : '';
            return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
    }
    return false;
}

function getInput($name, $default = NULL, $allow_get = true) {
    if (isset($_POST[$name])) {
        $output = $_POST[$name];
        if (!is_array($output)) {
            $output = htmlspecialchars($output);
        }
        return $output;
    }
    if ($allow_get) {
        if (isset($_GET[$name])) {
            $output = $_GET[$name];
            if (!is_array($output)) {
                $output = htmlspecialchars($output);
            }
            return $output;
        }
    }
    return isset($value) ? $value : null;
}
