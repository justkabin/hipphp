<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$header = "Password reset instructions sent.";
$body = "<p class='lead'>Instructions to reset your password have been sent to the email address you've entered.</p>";
echo drawPage([
"header" => $header,
"body"   => $body
]);
