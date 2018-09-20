<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
denyDirect();
new FooterJS("spectrum",getSiteURL()."node_modules/spectrum-colorpicker/spectrum.js");
new CSS("spectrum",getSiteURL()."node_modules/spectrum-colorpicker/spectrum.css");

$value = Vars::get("value");
$name = Vars::get("name");
$label = Vars::get("label");
$required = Vars::get("required");
$style = Vars::get("style");
if ($required) {
$required = "required='required'";
} else {
$required = NULL;
}
$disabled = Vars::get("disabled");
if ($disabled) {
$disabled = "disabled";
} else {
$disabled = NULL;
}
$autocomplete = Vars::get("autocomplete");
if ($autocomplete) {
$autocomplete = "autocomplete='$autocomplete'";
} else {
$autocomplete = NULL;
}
$prepend = Vars::get("prepend");
$extend = Vars::get("extend");
$class = Vars::get("class");
$placeholder = Vars::get("placeholder");
$form_group = Vars("form_group");

if ($form_group) {
$body = "<div class='form-group'>";
} else {
$body = NULL;
}
if ($label) {
$body .= "<label for='$name'>$label</label>&nbsp;";
}

if ($prepend || $extend) {
$body .= "<div class='input-group'>";
}

if ($prepend) {
$body .= "<div class='input-group-addon'>$prepend</div>";
}

$body .= "<input style='$style' name='$name' placeholder='$placeholder'  type='text' class='$class color' value='$value' $required $disabled $autocomplete>";

if ($extend) {
$body .= "<div class='input-group-addon'>$extend</div>";
}

if ($prepend || $extend) {
$body .= "</div>";
}

if ($form_group) {
$body .= "</div>";
}
echo $body;
