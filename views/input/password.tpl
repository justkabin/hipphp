{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
{if $form_group}
    <div class='form-group'>
    {/if}
    {if $label}
        <label for='$name'>{$label}</label>
    {/if}
    <input name="{$name}" type="password" class="{$class}" placeholder="{$placeholder}">
</div>
