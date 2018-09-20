<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Page {

    static function drawPage($params = []) {
        $defaults = [
            "heading" => NULL,
            "button" => NULL,
            "wrapper_class" => NULL,
            "breadcrumbs" => NULL,
            "footer" => NULL,
            "layout" => "one_column",
            "sidebar" => ""
        ];

        $params = array_merge($defaults, $params);
        $layout = $params['layout'];
        if (!$layout) {
            $layout = "one_column";
        }
        return view("layouts/$layout", $params);
    }

    static function forward($string = false, $variables = []) {
        $args = NULL;
        if (!empty($variables)) {
            $args = "?" . http_build_query($variables);
        }
        if ($string) {
            if (strpos($string, getSiteURL()) === false) {
                header("Location: " . getSiteURL() . $string . $args);
            } else {
                header("Location: " . $string) . $args;
            }
            exit();
        } else {
            if (isset($_SERVER["HTTP_REFERER"])) {
                $referer = htmlspecialchars($_SERVER["HTTP_REFERER"]);
                $referer = strtok($referer, '?');
                header("Location: " . $referer . $args);
                exit();
            } else {
                header("Location: " . getSiteURL() . $args);
                exit();
            }
        }
    }

    static function getRenderedHTML($path) {
        if (file_exists($path)) {
            ob_start();
            include($path);
            $var = ob_get_contents();
            ob_end_clean();
            return $var;
        }
    }

}
