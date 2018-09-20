<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$menuitems = listModels([
"type" => "Menuitem",
"order_by" => "weight"
]);
echo <<<HTML
<ul class="sortable-menus" style="list-style:none;margin-left:0px;padding-left:0px;width:100%;">
$menuitems
</ul>
HTML;
