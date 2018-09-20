<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$name = Vars::get("name");
$label = Vars::get("label");

echo <<<HTML
<div class='checkbox'>
<label>
<input type='checkbox' name='$name'> $label
</label>
</div>
HTML;
