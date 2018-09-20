<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$heading = Vars("heading");

$heading = (null === $heading) ? "<div class='card-header'>$heading</div>" : "";


$body = Vars("body");

echo <<<HTML
<div class="card">
$heading
<div class="card-body">
$body
</div>
</div>
HTML;
