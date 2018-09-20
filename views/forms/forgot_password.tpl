<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

echo view("input/email", [
"name"  => "email",
"class" => "form-control",
"label" => "Please enter your email address.",
"value" => NULL
]);
echo view("input/submit", [
"label" => "Submit",
"class" => "btn btn-success"
]);
