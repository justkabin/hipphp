<?php

{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}

denyDirect();
$guid = Vars("guid");
$model = getModel($guid);
$type = lcfirst($model->type);
$edit_url = getSiteURL() . "$type/edit/$guid";
$delete_url = addTokenToURL(getSiteURL() . "action/DeleteModel/$guid");
if ($model->owner_guid == getLoggedInUserGuid()) {
echo "<a href='$edit_url' class='btn btn-success btn-xs mr4' title='edit'><i class='fa fa-pencil'></i></a>";
echo "<a href='$delete_url' class='btn btn-danger btn-xs confirm' title='Delete?'><i class='fa fa-times'></i></a>";
}