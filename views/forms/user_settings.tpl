<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

gateKeeper();
$user = getLoggedInUser();
$tab = pageArray(2);
if (!$tab) {
$tab = "notifications";
}
$settings = Cache::get("user_settings", "session");
if ($settings) {
foreach ($settings as $key => $setting) {
$field_type = $setting['field_type'];
$name = $key;
$options = $setting['options'];
echo view("input/$field_type", [
"label" => translate("user_setting_field:$name"),
"options_values" => $options,
"name" => $name,
"value" => $user->getSetting($name),
"class" => "form-control",
"form_group" => true
]);
}
echo view("input/hidden", [
"name" => "tab",
"value" => $tab
]);
echo view("input/submit", [
"label" => "Save",
"class" => "btn btn-success"
]);
}
