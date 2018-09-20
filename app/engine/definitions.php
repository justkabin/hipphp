<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
define("DEVMODE", false);
define("TINY", 16);
define("SMALL", 32);
define("MEDIUM", 64);
define("LARGE", 128);
define("EXTRALARGE", 380);
define("HUGE", 1280);

$GLOBALS['default_css'] = array(
    "jquery_ui_dist" => "node_modules/jqueryui/jquery-ui.min.css",
    "fontawesome" => "node_modules/font-awesome/css/font-awesome.min.css",
    "site" => "assets/css/site.css",
    "timepicker" => "node_modules/timepicker/jquery.timepicker.min.css",
    "datetimepicker" => "node_modules/datetimepicker/dist/DateTimePicker.min.css",
    "bootstraptoggle" => "node_modules/bootstrap-toggle/css/bootstrap-toggle.min.css"
);
$GLOBALS['default_header_js'] = array(
    "jquery" => "node_modules/jquery/dist/jquery.min.js",
    "tinymce" => "node_modules/tinymce/tinymce.min.js"
);
$GLOBALS['default_footer_js'] = array(
    array("hipphp", "assets/js/hipphp.php", true),
    array("jquery_ui", "node_modules/jqueryui/jquery-ui.min.js", false),
    array("popper", "node_modules/popper.js/dist/umd/popper.min.js", false),
    array("bootstrap", "node_modules/bootstrap/dist/js/bootstrap.min.js", false),
    array("timeago", "node_modules/timeago/jquery.timeago.js", false),
    array("bootstraptoggle", "node_modules/bootstrap-toggle/js/bootstrap-toggle.min.js", false)
);
