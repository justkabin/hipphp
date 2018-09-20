{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
{if isset($form_group)}
    <div class='form-group'>
    {/if}
    {if $label}
        <label for='$name'>{$label}</label>
    {/if}
    <input name="{$name}" type="email" class="{$class}" placeholder="{$placeholder}" {if $required}required{/if}>
</div>
