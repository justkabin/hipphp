{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{if isset($message)}
    <div class="alert alert-{if $style}{$style}{else}info{/if} system_messages_holder" style="margin-bottom:0px;">
        <div class="container">
            <div class="system_messages">{$message}</div>
        </div>
    </div>
{/if}