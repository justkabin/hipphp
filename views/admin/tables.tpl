<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$content = NULL;
$tables = Dbase::getAllTables(false);
foreach ($tables as $key => $name) {
if ($name != "entities") {
$purge_url = addTokenToURL(getSiteURL()."action/purgeTable/$name");
$delete_url = addTokenToURL(getSiteURL()."action/deleteTable/$name");
$query = "SELECT COUNT(*) FROM `$name`";
$results = Dbase::getResultsArray($query);
if ($results) {
$records = $results[0]['COUNT(*)'];
$buttons = "<a href='$purge_url' class='btn btn-warning btn-xs confirm'>Purge</a>";
if ($name != "User") {
$buttons .= "<a href='$delete_url' class='btn btn-danger btn-xs confirm'>Delete</a>";
}
$content .= <<<HTML
<tr>
<td>$name</td>
<td>$records</td>
<td>$buttons</td>
</tr>

HTML;
}
}
}

$body = <<<HTML
<table class='table table-striped table-bordered table-hover'>
<tr>
<th>Table Name</th>
<th>Records</th>
<th>Actions</th>
</tr>
$content
</table>
HTML;

$header = "Tables";
echo view("page_elements/page_header", [
"text" => $header
]);
echo $body;
