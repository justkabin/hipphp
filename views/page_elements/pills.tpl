<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$tabs = Vars("tabs");
$content = NULL;
foreach ($tabs as $label => $url) {
$class = "flex-sm-fill text-sm-center nav-link";
$current = currentURL();
if (currentURL() == $url) {
$class .= ' active';
}
$label = translate($label);
$content .= <<<HTML
<a class="$class" href="$url">$label</a>
HTML;
}
?>
<div class="col-md-12 mt10 mb12">
    <nav class="nav nav-pills flex-column flex-sm-row mb10" style="width:100%;">
        <?php echo $content; ?>
    </nav>
</div>