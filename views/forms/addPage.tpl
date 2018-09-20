<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();
adminGateKeeper();

echo view("input/text", [
"name" => "label",
"class" => "form-control",
"form_group" => true,
"label" => "Menu Label",
"placeholder" => "Menu Label"
]);

echo view("input/submit",[
"label"=>"Save",
"class"=>"btn btn-success float-right"
]);