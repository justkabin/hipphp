{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
{if $extend !=false}
    {if $model}
        {view name='mediaobject:before' model=$model extend=true}
    {else}
        {view name='mediaobject:before' extend=true}
    {/if}
{/if}
<div class="media clearfix">
    <div class="{if $image_class}{$image_class}{else}mr6{/if}">
        {$image}
    </div>
    <div class="media-body clearfix">
        {if $button}
            <span class='pull-right btn-group'>
                {$button}
            </span>
        {/if}
        {if $title}
            <h5 class="mt-0 mb-1">{$title}</h5>
        {/if}
        {$description}
        <div style='clear:both;'></div>
        {if $extend != false}
            {if $model}
                {view name='mediaobject:body:after' model=$model extend=true}
            {else}
                {view name='mediaobject:body:after' extend='true'}
            {/if}
        {/if}
    </div>
</div>
{if $extend !=false}
    {if $model}
        {view name='mediaobject:after' model=$model extend=true}
    {else}
        {view name='mediaobject:after' extend=true}
    {/if}
{/if}