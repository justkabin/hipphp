{if $form_group}
    <div class="form_group mb10">
    {/if}
    <label class='label'>{$label}</label>
    <div class='list-group'>
        {foreach from=$options item=option}
            {assign "checked" "checked"}
            <li class="list-group-item">
                {$option|translate}
                <div class="material-switch pull-right">
                    <input id="switch_{$name}_{$option}" name="{$name}[]" type="checkbox" value='{$option}' {if is_array($value) && in_array($option,$value)}checked{/if}/>
                    <label for="switch_{$name}_{$option}" class="label-default"></label>
                </div>
            </li>
        {/foreach}
    </div>
    {if $form_group}
    </div>
{/if}

