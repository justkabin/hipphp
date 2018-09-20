<?php
{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

adminGateKeeper();
$extended_by = NULL;
$body = NULL;
$view_extensions = ViewExtension::getAll();
foreach ($view_extensions as $extension => $variables) {
$extended_by = NULL;
foreach ($variables as $variable) {
$extended_by .= <<<HTML
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extended by:  <strong>{$variable['src']} : {$variable['placement']}</strong> <br/>
HTML;
}
$body .= <<<HTML
<div class="well">
View:  <strong>$extension</strong><br/>
$extended_by
</div>
HTML;
}
echo view("page_elements/page_header", [
"text" => "View Extensions"
]);
echo $body;
