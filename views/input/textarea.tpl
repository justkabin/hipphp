{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{if $form_group}
    <div class='form-group'>
    {/if}
    {if $label}
        <label for='{$name}'>{$label|translate}</label>
    {/if}
    <textarea name="{$name}" class="form-control {$class}">{$value}</textarea>
    {if $form_group}
    </div>
{/if}