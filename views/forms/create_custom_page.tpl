<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

echo view("input/text", [
"label"    => "Unique Name",
"name"     => "name",
"class"    => "form-control",
"required" => true
]);
echo view("input/text", [
"label"    => "Menu Label",
"name"     => "label",
"class"    => "form-control",
"required" => false
]);
echo view("input/text", [
"label"    => "Page Title",
"name"     => "title",
"class"    => "form-control",
"required" => true
]);
echo view("input/editor", [
"label" => "Page Body",
"name"  => "body"
]);
echo view("input/submit", [
"label" => "Save",
"class" => "btn btn-success"
]);
