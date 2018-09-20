{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
<div class="container">
    {view name="page_elements/breadcrumbs" breadcrumbs=$breadcrumbs}
    {if $heading || $button || $body}
        <div class="container">
            {if {$heading} || {$button}}
                <div class='row'>
                    {view name='page_elements/page_heading' heading={$heading} button={$button}}
                </div>
            {/if}
            <div class="row mt20">
                <div class='col-md-2'>
                    {$sidebar}
                </div>
                <div class='col-md-10'>
                    {$body}
                </div>
            </div>
        </div>
    {/if}
</div>