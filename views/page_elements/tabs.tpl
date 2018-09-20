<?php
{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

$tabs = Vars("tabs");
$content = NULL;
foreach ($tabs as $tab) {
$url = $tab[0];
$label = $tab[1];
$active = $url == currentPage() ? "active":"";
$content .= <<<HTML
<li class="nav-item">
<a class="nav-link $active" href="$url">$label</a>
</li>
HTML;
}
?>
<ul class="nav nav-tabs">
    <?php echo $content; ?>
</ul>