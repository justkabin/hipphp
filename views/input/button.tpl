<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$class = Vars("class");
$label = Vars("label");
$url = Vars("url");
$url = normalizeURL($url);

echo <<<HTML
<a href='$url' class='$class'>$label</a>
HTML;
