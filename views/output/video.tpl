<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$url = Vars::get("value");

use \TubeLink\TubeLink;

if ($url) {
$thumbnail = Vars::get("thumbnail");

$parser = new TubeLink();
$parser->registerService(new \TubeLink\Service\Youtube());

$tube = $parser->parse($url);

if ($thumbnail) {
echo $tube->thumbnail();
} else {
echo $tube->render();
}
}
