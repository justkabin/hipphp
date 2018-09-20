{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
{if $form_group}
    <div class="form-group">
    {/if}
    <label for="{$name}">{$label|translate}</label>
    <textarea style='visibility:hidden;' id="{$name}" class="{$class} tinymce" name="{$name}" rows="{$rows}">{$value}</textarea>
    {if $form_group}
    </div>
{/if}