<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

require_once(dirname(dirname(dirname(__FILE__)))."/engine/start.php");
header("Content-type: text/css; charset: UTF-8");
$page = getInput("page");
$css_cache = Setting::get("css_cache");
if (!isset($css_cache)) {
$css_cache = true;
}
if ($css_cache) {
$cssoutput = Cache::get("css_".$page, "file");
}
if (!$cssoutput) {
$cssoutput = NULL;
$cssArray = CSS::getAll();
if (!empty($cssArray)) {
uasort($cssArray, function($a, $b) {
return $a['weight'] - $b['weight'];
});
foreach ($cssArray as $css) {
if (strpos($css['css'], "http") === false) {
$csscontent = $css['css'];
$cssoutput .= file_get_contents($csscontent);
}
}
}
}
echo $cssoutput;
