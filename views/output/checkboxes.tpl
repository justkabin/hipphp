<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
denyDirect();

$value = Vars::get('value');
$body = Vars::get("label");
if ($body) {
$body = "<strong>$body</strong><br/>";
}
if (!is_array($value)) {
if ($value) {
$body .= ": ".$value;
}
} else {
if (!empty($value)) {
foreach ($value as $key => $v) {
$body .= $v."<br/>";
}
}
}
echo $body;
