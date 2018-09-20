<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
denyDirect();

$user_guid = Vars::get("user_guid");
$user = getModel($user_guid);
$name = $user->first_name." ".$user->last_name;
$email = $user->email;
$code = $user->email_verification_code;

echo translate("verify_email:body", [
$name,
getSiteURL(),
$email,
$code,
getSiteName()
]);
