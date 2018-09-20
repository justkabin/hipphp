<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$home_page_text = Setting::get("home_page");

echo view("input/editor", [
"name"  => "home_page",
"label" => "Home page text",
"value" => $home_page_text
]);
echo view("input/submit", [
"label" => "Save",
"class" => "btn btn-success"
]);
