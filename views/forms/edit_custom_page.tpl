<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

adminGateKeeper();
$guid = pageArray(1);
$page = getModel($guid);

echo view("input/hidden", [
"name"  => "guid",
"value" => $guid
]);

echo view("input/text", [
"label"    => "Unique Name",
"name"     => "name",
"class"    => "form-control",
"required" => true,
"value"    => $page->name
]);
echo view("input/text", [
"label"    => "Menu Label",
"name"     => "label",
"class"    => "form-control",
"required" => false,
"value"    => $page->label
]);
echo view("input/text", [
"label"    => "Page Title",
"name"     => "title",
"class"    => "form-control",
"required" => true,
"value"    => $page->title
]);
echo view("input/editor", [
"label" => "Page Body",
"name"  => "body",
"value" => $page->body
]);
echo view("input/submit", [
"label" => "Save",
"class" => "btn btn-success"
]);
