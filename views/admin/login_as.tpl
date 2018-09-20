<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();
adminGateKeeper();

$guid = Vars::get("guid");
if ($guid != getLoggedInUserGuid()) {
$url = addTokenToURL(getSiteURL()."action/loginas/$guid");
echo "<a href='$url' class='btn btn-danger btn-xs'>Login As</a>";
}