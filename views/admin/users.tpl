<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

adminGateKeeper();
$limit = getInput("limit", 5);
$offset = getInput("offset", 0);
$access = getIgnoreAccess();
setIgnoreAccess();
$count = getModels([
"type"   => "User",
"offset" => 0,
"count"  => true
]);
$users = listModels([
"type"   => "User",
"limit"  => $limit,
"offset" => $offset
]
);
setIgnoreAccess($access);
$pagination = view("page_elements/pagination", [
"limit"  => $limit,
"offset" => $offset,
"count"  => $count,
"url"    => "admin/users"
]);
$body = <<<HTML
$pagination
$users
$pagination
HTML;
$header = "Users";
echo view("page_elements/page_header", [
"text" => $header
]);
echo $body;
