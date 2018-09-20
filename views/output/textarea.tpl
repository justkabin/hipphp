<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$value = Vars::get('value');
$body = Vars::get('label');
if ($body) {
$body = "<strong>$body</strong>";
}
$body .= ": ".$value;
echo $body;
