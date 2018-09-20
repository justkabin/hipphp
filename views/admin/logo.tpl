<?php

{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}

denyDirect();
echo getSiteLogo();
echo "<p class='lead'>Upload a new logo, or leave blank to keep existing.</p>";
echo "<p>Ideal size is 150px x 30px.</p>";
echo drawForm([
"name"    => "upload_logo",
"method"  => "post",
"action"  => "UploadLogo",
"enctype" => "multipart/form-data"
]);

