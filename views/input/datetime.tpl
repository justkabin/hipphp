<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$input = view("input/text", [
"extend"=>"<span class='glyphicon glyphicon-calendar'></span>"
]);
echo <<<HTML
<div class="form-group">
<div class='input-group date datetimepicker'>
$input
</div>
</div>
HTML;
