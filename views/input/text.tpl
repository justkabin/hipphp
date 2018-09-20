{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{if $form_group}
    <div class='form-group'>
    {/if}
    {if $label}
        <label for='{$name}'>{$label}</label>&nbsp;
    {/if}
    {if $prepend || $append}
        <div class='input-group'>
        {/if}
        {if $prepend}
            <div class='input-group-prepend'>{$prepend}</div>
        {/if}
        <input style='{$style}' name='{$name}' placeholder='{$placeholder}'  type='text' class='{$class}' value='{$value}' {if $required}required{/if}>
        {if $append}
            <div class='input-group-append'>{$append}</div>
        {/if}
        {if $prepend || $append}
        </div>
    {/if}
    {if $form_group}
    </div>
{/if}