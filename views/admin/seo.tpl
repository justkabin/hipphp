<?php
{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();

$metatags = Metatag::get();
$body = "<table class='table table-striped table-bordered table-condensed'>";
$body .= "<tr>";
$body .= "<th>Page</th>";
$body .= "<th>Parameter</th>";
$body .= "<th>Value</th>";
$body .= "</tr>";
$body .= viewModelList($metatags);
$body .= "</table>";

$header = "SEO";
echo view("page_elements/page_header", [
"text" => $header
]);
echo $body;
