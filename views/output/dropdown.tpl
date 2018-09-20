<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$value = Vars::get('value');
$label = Vars::get('label');
$body = <<<HTML
<strong>$label:  </strong>$value
HTML;
echo $body;
