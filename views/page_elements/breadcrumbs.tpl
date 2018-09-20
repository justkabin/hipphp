{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{if $breadcrumbs}
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                {foreach from=$breadcrumbs key=label item=url}
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{$url}">{$label|translate}</a>
                    </li>
                {/foreach}
            </ol>
        </nav>
    </div>
{/if}
