<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();

$byline = $timeago = NULL;

$guid = pageArray(2);
$model = getModel($guid);
if ($model->owner_guid) {
$owner = getModel($model->owner_guid);
$byline = "<small>by " . $owner->first_name . " " . $owner->last_name;
}
$timeago = view("output/friendly_time", [
"timestamp" => $model->time_created
]);

echo $byline . " " . $timeago;

$fields = $model->fields();
if ($model->description) {
echo view("output/editor", [
"value" => $model->description
]);
}
if (!empty($fields)) {
echo "<table class='table table-striped table-hovered'>";
foreach ($fields as $key => $attrs) {
if ($key != "access_id" && $key != "title" && $key != "description") {
echo "<tr>";
echo "<td>" . ucfirst($key) . "</td>";
echo "<td>" . $model->$key . "</td>";
echo "</tr>";
}
}
echo "</table>";
}

if ($model->allowComments()) {

echo "<div class='well'>";
echo "<h3>Comments</h3>";
echo view("output/block_comments", [
"guid" => $guid
]);
echo "</div>";
}