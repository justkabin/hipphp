<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

echo view("input/text", [
"name"  => "confirm_deletion",
"class" => "form-control",
"label" => "To delete all site date, type 'DELETE ALL DATA' without the quotes in the box below and click submit."
]);
echo view("input/submit", [
"label" => "Submit",
"class" => "btn btn-danger"
]);
