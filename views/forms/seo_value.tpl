<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$inputs = Vars::get("inputs");
foreach ($inputs as $input) {
echo view("input/".$input['type'], [
"name"  => $input['name'],
"value" => $input['value'],
"class" => (isset($input['class']) ? $input['class'] : "form-control"),
"label" => (isset($input['label']) ? $input['label'] : "")
]);
}
echo "<button class='btn btn-warning' onclick='location.reload();'>Cancel</button>";
