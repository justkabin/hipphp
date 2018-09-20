<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$value = Vars::get('value');
$body = "<strong>".Vars::get('label')."</strong>";
$body .= ": ".$value;
echo $body;
