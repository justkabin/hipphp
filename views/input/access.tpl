<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$options = [];
$label = Vars::get("label");
$value = Vars::get("value");
$options = accessHandlerDropdown();
$form_group = Vars("form_group");
if (!adminLoggedIn()) {
unset($options['Admin']);
}
if ($form_group) {
echo "<div class='form-group'>";
}
echo view("input/dropdown", [
"label"          => $label,
"name"           => "access_id",
"options_values" => $options,
"value"          => $value
]);
if ($form_group) {
echo "</div>";
}