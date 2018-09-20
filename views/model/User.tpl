{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{assign "image" {avatar guid=$guid size=32 class="mr3"}}
{view name="bootstrap/mediaobject" image=$image title="{$model->first_name} {$model->last_name}" extend=true}