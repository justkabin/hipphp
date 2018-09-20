<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
denyDirect();

$label = Vars::get("label");
$value = Vars::get("value");
if ($value) {
$date = date("m/d/Y", $value);
} else {
$date = NULL;
}

echo "<strong>$label: </strong>".$date;
