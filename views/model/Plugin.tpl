{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{assign "edurl" "{siteUrl}action/{if $model->status eq "disabled"}enable{else}disable{/if}Plugin/{$model->guid}"}
{assign "movetobottom" "{siteUrl}action/movePluginToBottom/{$model->guid}"}
<li class="alert alert-{if $model->status eq "disabled"}danger{else}success{/if} plugin-disabled clearfix" id="guid_{$model->guid}" style="cursor:move;">
    <p>
        <strong>{$model->label}</strong>
    </p>

    <p>
        {$model->description}
    </p>
    <a href="{$edurl|@tokenize}" class="float-right btn-sm btn-danger confirm">
        <i class="fa fa-{if $status eq "disabled"}plus{else}minus{/if}-circle">
            {if $model->status eq "disabled"}Enable{else}Disable{/if}
        </i>
    </a>
    <a class='move_plugin_to_bottom confirm' href='{$movetobottom|@tokenize}'>Move to bottom</a>
</li>