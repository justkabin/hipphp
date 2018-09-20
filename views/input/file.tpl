{if !isset($class)}
    {assign "class" "form-control-file btn btn-default"}
{/if}
<div class="form-group">
    {if $label}
        <label for="exampleFormControlFile1">{$label}</label>
    {/if}
    <input type="file" class="{$class}" name="{$name}">
</div> 