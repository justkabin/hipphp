<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$label = Vars("label") ? Vars("label") : NULL;
$class = Vars("class") ? Vars("class") : "btn btn-success";
$href = Vars("href") ? Vars("href") : NULL;

echo "<a href='$href' class='$class'>$label</a>";
