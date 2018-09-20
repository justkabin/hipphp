<?php
{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$model_type = Vars("model_type");
if ($model_type) {
$model_type = ucfirst($model_type);
$class = ucfirst($model_type);
if (class_exists($class)) {
$model = new $class;
$fields = $model->fields();
if (!empty($fields)) {
echo view("input/hidden", [
"name" => "model_type",
"value" => $model_type
]);
foreach ($fields as $field => $attrs) {
echo view("input/" . $attrs['type'], [
"name" => $field,
"class" => $attrs['class'],
"label" => $attrs['label'],
"form_group" => true,
"required" => isset($attrs['required']) ? $attrs['required'] : false
]);
}
echo view("input/access", [
"name" => "access_id",
"class" => "form-control"
]);
echo view("input/submit", [
"label" => "Save",
"class" => "btn btn-success"
]);
}
}
}

