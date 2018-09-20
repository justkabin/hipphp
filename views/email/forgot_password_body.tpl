<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$access = getIgnoreAccess();
setIgnoreAccess();
$user_guid = Vars::get("user_guid");
$user = getModel($user_guid);
if ($user) {
$password_reset_code = $user->password_reset_code;
$link = getSiteURL()."forgotPassword/".$password_reset_code."/".$user->email;
$body = translate("password_reset:email:body", [
$user->first_name." ".$user->last_name,
getSiteName(),
$link
]);
echo $body;
}
setIgnoreAccess($access);
