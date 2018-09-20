<?php
/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
require_once((dirname(dirname(dirname(__FILE__)))) . "/app/engine/ajax_start.php");
denyDirect();
$session = NULL;
$token = generateToken();
if (loggedIn()) {
    $user = getLoggedInUser();
    $session = $user->session;
}
header("Content-type: application/javascript");
?>
/* <script> /**/


    var hipphp = {
        init: function() {
            hipphp.modal();
            hipphp.profile();
            hipphp.tinymce();
            hipphp.timeago();
            hipphp.confirm();
            hipphp.sortable_plugins();
            hipphp.sortable_menus();
            hipphp.tooltip();
            hipphp.dismiss_notification();
            hipphp.vertical();
            hipphp.filepicker();
            hipphp.datepicker();
            hipphp.ajax_fields();
            hipphp.masonry();
            hipphp.tabs();
            hipphp.dismiss_alert();
            hipphp.ajax_model_list();
            hipphp.timepicker();
            hipphp.datetimepicker();
            hipphp.colorpicker();
            hipphp.location_input();
        },
        colorpicker: function() {
            if ($(".color").length > 0) {
                $(".color").spectrum();
            }
        },
        token: function() {
            return "<?php echo $token; ?>";
        },
        session: function() {
            return "<?php echo $session; ?>";
        },
        url: function() {
            return "<?php echo getSiteURL(); ?>";
        },
        path: function() {
            return "<?php echo addslashes(SITEPATH); ?>";
        },
        pageArray: function() {
            return <?php echo json_encode(pageArray()); ?>;
        },
        secret: function() {
            return "<?php echo SITESECRET; ?>";
        },
        loggedInUserGuid: function() {
            return "<?php echo getLoggedInUserGuid(); ?>";
        },
        currentPage: function() {
            return "<?php echo currentPage(); ?>";
        },
        post: function(path, vars, callback) {
            if (path.indexOf(hipphp.url) === -1) {
                path = hipphp.url() + path;
            }
            vars.token = hipphp.token();
            return $.post(path, vars, callback);
        },
        ajaxaction: function(action, actiondata, div) {
            hipphp.post("ajax/ajax_action_handler.php", {
                token: hipphp.token(),
                action: action,
                data: actiondata
            }, function(returnData) {
                $(div).html(returnData);
                hipphp.timeago();
            });
        },
        view: function(view, vars) {
            return hipphp.post("ajax/ajax_view_handler.php", {
                view: view,
                vars: vars
            }, function(returnData) {
                return returnData;
            });
        },
        displayNotification: function(message, messageclass) {
            if (!messageclass) {
                var messageclass = "info";
            }
            $(".system_messages").html(message);
            $(".system_messages_holder").removeClass("alert-info").addClass("alert-" + messageclass).show();
            $(".system_messages_holder").removeClass("alert-info").addClass("alert-" + messageclass).fadeTo(2000, 1000).slideUp(1000, function() {
                $(".system_messages_holder").slideUp(1000);
            });
        },
        location_input: function() {
            if ($(".location_input").length > 0) {
                $(".location_input").geocomplete();
            }
        },
        ajax_model_list: function() {
            $("body").on("click", ".show_more_entities", function() {
                var button = $(this);
                var params = button.data("params");
                var id = button.data("id");
                var count = button.data("count");
                var count_shown = button.data("count_shown");
                button.remove();
                hipphp.post("app/ajax/ajax_view_handler.php", {
                    view: "ajax/model_list_body",
                    vars: {
                        params: params,
                        id: id,
                        count: count,
                        count_shown: count_shown
                    }
                }, function(returnData) {
                    $("#" + id).append(returnData);
                    hipphp.timeago();
                });
            });
        },
        tabs: function() {
            $('.tabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
        },
        masonry: function() {
            if ($(".masonry3col").length > 0) {
                $(".masonry3col").each(function() {
                    var div = $(this);
                    div.imagesLoaded(function() {
                        $.when(
                                div.masonry({
                                    itemSelector: '.masonry_element',
                                    columnwidth: '.col-xs-4',
                                    percentPosition: true
                                })
                                ).then(function() {
                            div.css({
                                opacity: 1
                            });
                        });
                    });
                });
            }
            if ($(".masonry4col").length > 0) {
                $(".masonry4col").each(function() {
                    var div = $(this);
                    div.imagesLoaded(function() {
                        $.when(
                                div.masonry({
                                    itemSelector: '.masonry_element',
                                    columnwidth: '.col-xs-3',
                                    percentPosition: true
                                })
                                ).then(function() {
                            div.css({
                                opacity: 1
                            });
                        });
                    });
                });
            }
        },
        dismiss_notification: function() {
            if ($(".dismiss_notification").length > 0) {
                $(".dismiss_notification").on("click", function(e) {
                    var element = $(this);
                    e.preventDefault();
                    var guid = element.siblings(".guid").eq(0).val();
                    hipphp.post("app/ajax/ajax_action_handler.php", {
                        action: "DismissNotification",
                        data: {
                            guid: guid
                        }
                    }, function() {
                        if (element.attr('href') === undefined) {
                            location.reload();
                        } else {
                            window.location = element.attr('href');
                        }
                    });
                });
            }
        },
        tooltip: function() {
            $('[data-toggle="tooltip"]').tooltip({
                container: "body"
            });
        },
        modal: function() {
            if ($('#modal').length > 0) {
                $('#modal').modal(
                        {
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        }
                );
            }
        },
        profile: function() {
            if ($('.avatar').length > 0) {
                $('.avatar').hoverIntent(function() {
                    $('.edit-avatar').fadeIn();
                }, function() {
                    $('.edit-avatar').fadeOut();
                });
            }
        },
        tinymce: function() {
            tinyMCE.init({
                mode: "specific_textareas",
                editor_selector: "tinymce",
                plugins: [
                    "textcolor advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks fullscreen",
                    "code"
                ],
                height: 100,
                toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | link browse media code smileys",
                extended_valid_elements: 'img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]|a[href|test] data',
                convert_urls: false,
                verify_html: false,
                parser: tinymce.html.DomParser,
                menubar: false,
                statusbar: false
    <?php
    echo view("page_elements/tinymce_buttons_wrapper");
    ?>
            });
        }
        ,
        filepicker: function() {
            $(".filepicker").on("click", function(e) {
                e.stopPropagation();
                var filepicker = $(this);
                $(".filepicker").removeClass("active");
                filepicker.addClass("active");
            });
        }
        ,
        timeago: function() {
            $('.timeago').timeago();
        },
        confirm: function() {
            if ($(".confirm").length > 0) {
                $('body').on('click', function(e) {
                    $('.confirm').each(function() {
                        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                            $(this).popover('hide');
                        }
                    });
                });
                $(".confirm").on("click", function(e) {
                    e.preventDefault();
                }).popover({
                    placement: "top",
                    title: "Are you sure?",
                    content: function() {
                        var href = $(this).attr('href');
                        var content = '<center><a class="btn btn-danger btn-sm mr8" href="' + href + '">Yes</a>';
                        content += '<button class="btn btn-success btn-sm" onclick="$(&quot;.confirm&quot;).popover(&quot;hide&quot;);">No</button></center>';
                        return content;
                    },
                    html: true,
                    delay: 100
                });
            }
        },
        urlParam: function(name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results === null) {
                return null;
            } else {
                return results[1] || 0;
            }
        },
        sortable_plugins: function() {
            if ($('.sortable-list').length > 0) {
                $('.sortable-list').sortable({
                    connectWith: '.sortable-list',
                    update: function() {
                        var order = $(this).sortable('toArray');
                        hipphp.post('app/ajax/ajax_action_handler.php', {
                            action: "UpdatePluginOrder",
                            data: {
                                order: order
                            }
                        });
                    }
                });
            }
        },
        sortable_menus: function() {
            if ($('.sortable-menus').length > 0) {
                $('.sortable-menus').sortable({
                    connectWith: '.sortable-menus',
                    update: function() {
                        var order = $(this).sortable('toArray');
                        hipphp.post('app/ajax/ajax_action_handler.php', {
                            action: "UpdateMenuOrder",
                            data: {
                                order: order
                            }
                        })
                    }
                });
            }
        },
        vertical: function() {
            if ($(".vertical").length > 0) {
                $(".vertical").each(function() {
                    var div = $(this);
                    var parent = $(this).parent();
                    var div_height = div.height();
                    var parent_height = parent.height();
                    var top = (parent_height - div_height) / 2;
                    div.css("margin-top", top + "px");
                    div.css("top", top + "px");
                });
            }
        },
        gotoplugin: function(guid) {
            var element = $("#guid_" + guid);
            $('html,body').animate({scrollTop: element.offset().top}, 800);
            element.css("border", "4px dashed #AFAAAA");
        },
        datepicker: function() {
            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"
            });
            $(".datepicker").each(function() {
                var div = $(this);
                div.on("change", function() {
                    var val = div.val();
                    var d = new Date(val);
                    var da = d.getTime() / 1000;
                    div.parent().children(".actual_date").val(da);
                });
            });
        },
        ajax_fields: function() {
            if ($(".ajax_field").length > 0) {
                $.each($(".ajax_field"), function() {
                    var field = $(this);
                    field.click(function() {
                        if ($(".ajax_field.active").length == 0) {
                            var value = field.html();
                            var action = field.attr("data-action");
                            var form = field.attr("data-form");
                            var guid = field.attr("data-guid");
                            var name = field.attr("data-name");
                            hipphp.post("app/ajax/ajax_view_handler.php", {
                                view: "ajax/form",
                                vars: {
                                    inputs: [
                                        {
                                            name: name,
                                            value: value,
                                            type: "text"
                                        },
                                        {
                                            name: "guid",
                                            value: guid,
                                            type: "hidden"
                                        },
                                        {
                                            name: "",
                                            value: "",
                                            type: "submit",
                                            label: "Save",
                                            class: "btn btn-success"
                                        }
                                    ],
                                    action: action,
                                    form_name: form
                                },
                                session: hipphp.session()
                            }, function(returnData) {
                                field.addClass("active");
                                field.html(returnData);
                            });
                        }
                    });
                });
                $(".ajax_field .ajax_input_field").click(function(e) {
                    e.stopPropagation();
                });
            }
        },
        dismiss_alert: function() {
            window.setTimeout(function() {
                $(".system_messages_holder").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 4000);
        },
        timepicker: function() {
            if ($(".timepicker").length > 0) {
                $(".timepicker").timepicker();
            }
        },
        datetimepicker: function() {
            if ($(".datetimepicker").length > 0) {
                $(".datetimepicker").datetimepicker();
            }
        }
    };
