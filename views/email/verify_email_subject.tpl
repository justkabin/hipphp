<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$user_guid = Vars::get("user_guid");
$user = getModel($user_guid);
$name = $user->first_name." ".$user->last_name;
$SiteName = getSiteName();
$output = translate("verify_email:subject", [
$name,
$SiteName
]);
echo $output;
