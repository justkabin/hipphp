{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
{if $form_group}
    <div class='form-group'>
    {/if}
    {if $label}
        <label for='{$name}'>{$label}</label>&nbsp;
    {/if}
    <div class='input-group'>
        <div class='input-group-prepend'>{$prepend}</div>
        <input style='{$style}' name='{$name}' placeholder='{$placeholder}'  type='text' class='{$class} form-control datepicker' value='{$value|date_format:"%D"}'{if $required}required{/if}>
        <div class='input-group-append'>{$append}</div>
    </div>
    {if $form_group}
    </div>
{/if}