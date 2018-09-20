<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

adminGateKeeper();

$delete_url = addTokenToURL(getSiteURL() . "action/deleteLogo");

echo view("input/file", [
"name" => "avatar",
"class" => "form-control",
"form_group" => true
]);
echo view("input/submit", [
"class" => "btn btn-success ml8",
"label" => "Upload"
]);
echo "<a href='$delete_url' class='btn btn-danger confirm'>Delete</a>";
