{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{assign "on" "{if $on}$on{else}On{/if}"}
{assign "off" "{if $off}$off{else}Off{/if}"}

{if $class}
    <div class="{$class}">
    {/if}
    {if $form_group}
        <div class="form-group">
        {/if}
        {if $label}
            <label>{$label}</label>
        {/if}
        <input class="form-control" type="checkbox" {if $value}checked{/if} data-toggle="toggle" data-on="{$on}" data-off="{$off}">
        {if $form_group}
        </div>
    {/if}
    {if $class}
    </div>
{/if}