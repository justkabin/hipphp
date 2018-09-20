<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
denyDirect();

$heading = Vars("heading");
$body = Vars("body");

if ($heading) {
$heading = "<div class='card-header'>$heading</div>";
}
echo <<<HTML
<div class="card">
$heading
<div class="card-body">
$body
</div>
</div>
HTML;
