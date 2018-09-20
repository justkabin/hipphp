{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{view name="navigation:before"}
{view name="page_elements/system_messages"}


<nav class="navbar navbar-expand-sm navbar-light bg-faded">
    <div class="container">
        <a class="navbar-brand" href="{siteUrl}">{siteName}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample03">
            <ul class="navbar-nav mr-auto">
                {listMenuItems menu="header_left"}
            </ul>
            <ul class="navbar-nav ml-auto">
                {listMenuItems menu="header_right"}
            </ul>
        </div>
    </div>
</nav>
{view name="navigation:after"}