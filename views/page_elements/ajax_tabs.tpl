<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$tabs = Vars("tabs");
$labels = $contents = NULL;
$count = 0;
foreach ($tabs as $label => $content) {
$class = $count == 0 ? "active" : "";
$id = "tab_".rand(0, 1000);
$labels .= "<li role='presentation' class='$class'><a href='#$id' aria-controls='$id' role='tab' data-toggle='tab'>$label</a></li>";
$contents .= "<div role='tabpanel' class='tab-pane $class' id='$id'>$content</div>";
$count++;
}
echo <<<HTML
<div>
<ul class="nav nav-tabs" role="tablist">
$labels
</ul>
<div class="tab-content">
$contents
</div>
</div>
HTML;
