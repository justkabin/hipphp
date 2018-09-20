{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{literal}
    ,setup: function (ed) {
    ed.on("init",function (ed, evt) {
    $(".tinymce_holder").animate({
    opacity:1
    });
    });
{/literal}
{view name="tinymce/buttons"}
{literal}
    }
{/literal}