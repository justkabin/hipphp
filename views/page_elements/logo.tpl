<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$sitename = getSiteName();
$siteurl = getSiteURL();

echo <<<HTML
<h1 class='text-center'><a href='$siteurl'>$sitename</a></h1>
HTML;
