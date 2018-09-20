{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{view name="page_elements/breadcrumbs" breadcrumbs=$breadcrumbs}

{if $heading || $button || $body}
    <div class="container">
        {if {$heading} || {$button}}
            {view name='page_elements/page_heading' heading={$heading} button={$button}}
        {/if}
        {if $body}
            <div class="row mt20">
                {$body}
            </div>
        {/if}
    </div>
{/if}