<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$guid = pageArray(2);
$model = getModel($guid);
$fields = $model->fields();
if (!empty($fields)) {
echo view("input/hidden", [
"name" => "guid",
"value" => $guid
]);
echo view("input/hidden", [
"name" => "model_type",
"value" => $model->type
]);
foreach ($fields as $field => $attrs) {
echo view("input/" . $attrs['type'], [
"name" => $field,
"class" => $attrs['class'],
"label" => $attrs['label'],
"form_group" => true,
"required" => isset($attrs['required']) ? $attrs['required'] : false,
"value" => $model->$field
]);
}
echo view("input/access", [
"name" => "access_id",
"class" => "form-control",
"label" => "Access"
]);
echo view("input/submit", [
"label" => "Save",
"class" => "btn btn-success"
]);
}