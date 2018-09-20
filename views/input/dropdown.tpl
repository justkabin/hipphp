{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
{if $form_group}
    <div class="form-group">
    {/if}
    {if $label}
        <label for="input_{$name}">{$label}</label>
    {/if}
    <select class="form-control" id="input_{$name}" name="{$name}">
        {foreach from=$options key=k item=v}
            <option value="{$k}" {if $value eq $k}selected{/if}>{$v|translate}</option>
        {/foreach}
    </select>
    {if $form_group}
    </div>
{/if}