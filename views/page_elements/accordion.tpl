<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$contents = Vars("contents");
$class = Vars("class");
if (!$class) {
$class = "default";
}

$count = 0;
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
    foreach ($contents as $content) {
    $expanded = $count == 0 ? "true" : "false";
    $in = $count == 0 ? "in" : "";
    $header = $content['header'];
    $body = $content['body'];
    ?>
    <div class="panel panel-<?php echo $class; ?>">
        <div class="panel-heading" role="tab" id="heading-<?php echo $count; ?>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $count; ?>" aria-expanded="<?php echo $expanded; ?>" aria-controls="collapse-<?php echo $count; ?>">
                    <?php echo $header; ?>
                </a>
            </h4>
        </div>
        <div id="collapse-<?php echo $count; ?>" class="panel-collapse collapse <?php echo $in; ?>" role="tabpanel" aria-labelledby="heading-<?php echo $count; ?>">
            <div class="panel-body">
                <?php echo $body; ?>
            </div>
        </div>
    </div>
    <?php
    $count++;
    }
    ?>
</div>