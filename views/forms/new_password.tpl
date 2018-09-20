<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$guid = Vars::get("guid");
$code = Vars::get("code");
$user = getModel($guid);
echo view("input/hidden", [
"name"  => "guid",
"value" => $guid
]);
echo view("input/hidden", [
"name"  => "code",
"value" => $code
]);
echo view("input/password", [
"name"  => "password",
"label" => "New Password",
"class" => "form-control",
"value" => NULL
]);
echo view("input/password", [
"name"  => "password2",
"label" => "New Password (Again)",
"class" => "form-control",
"value" => NULL
]);
echo view("input/submit", [
"label" => "Save",
"class" => "btn btn-success"
]);
