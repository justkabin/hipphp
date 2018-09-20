<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$id = Vars("id");
$heading = Vars("heading");
$body = Vars("body");
$save_button_id = Vars("save_button_id");
$save_button_text = Vars("save_button_text");
$save_button_class = Vars("save_button_class");
$show_close_button = Vars("show_close_button");
$close_button_text = Vars("close_button_text");
$close_button_class = Vars("close_button_class");

if (!$save_button_text) {
$save_button_text = "Close";
}

if (!$save_button_class) {
$save_button_class = "btn btn-success";
}

$close_button = NULL;
if (!$close_button_text) {
$close_button_text = "Close";
}
if (!$close_button_class) {
$close_button_class = "btn btn-default";
}
if ($show_close_button) {
$close_button = "<button type='button' class='$close_button_class' data-dismiss='modal'>Close</button>";
}

$save_button = "<button type='button' class='$save_button_class' id='save_button_id'>$save_button_text</button>";

echo <<<HTML
<div class="modal fade" id="$id" tabindex="-1" role="dialog" aria-labelledby="modalLabel_$id">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="modalLabel_$id">$heading</h4>
</div>
<div class="modal-body">
$body
</div>
<div class="modal-footer">
$close_button
$save_button
</div>
</div>
</div>
</div>
HTML;
