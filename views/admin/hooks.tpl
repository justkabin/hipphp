<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

adminGateKeeper();
$extended_by = $page = NULL;
$body = NULL;
$function_list = NULL;
$hooks = Hook::getAllHooks();
if ($hooks) {
foreach ($hooks as $name => $functions) {
$function_list = NULL;
foreach ($functions as $function) {
$function_list .= <<<HTML
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Class:  <strong>$function</strong>
HTML;
}
$body .= <<<HTML
<div class="well">
Hook Name:  <strong>$name</strong><br/>
$function_list
</div>
HTML;
}
$page = <<<HTML
$body
HTML;
}
echo view("page_elements/page_header", [
"text" => "Hooks"
]);
echo $page;
