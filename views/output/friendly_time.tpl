<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$date = date("l jS \of F Y h:i:s A", Vars("timestamp"));
echo $date;
