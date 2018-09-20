<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class AdminRouter extends Router {

    public function __construct() {
        adminGateKeeper();
        $breadcrumbs = array(
            "breadcrumb:home" => getSiteURL(),
            "breadcrumb:admin" => getSiteURL() . "admin"
        );

        $tab = pageArray(1);

        if (!$tab) {
            forward("admin/general");
        }
        $sidebar = '<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">';
        $sidebar .= MenuItem::listMenuItems("admin_sidebar");
        $sidebar .= '</div>';
        switch ($tab) {
            case "general":
                $breadcrumbs["breadcrumb:general"] = getSiteURL() . "admin/general";
                $heading = "General Settings";
                $body = view("admin/general");
                $layout = "left_sidebar";
                break;
            case "plugins":
                $breadcrumbs["breadcrumb:plugins"] = getSiteURL() . "admin/plugins";
                $heading = "Plugins";
                $plugins = listModels([
                    "type" => "Plugin",
                    "order_by" => "plugin_order"
                ]);
                $layout = "left_sidebar";
                $body = <<<HTML
        <div class="col-md-12">
<ul class="sortable-list" style="list-style:none;margin-left:0px;padding-left:0px;width:100%;">
    $plugins
</ul>
        </div>
HTML;
                break;
            default:
                $body = view("admin/$tab");
                break;
        }


        $buttons = "<div class='btn-toolbar mb10' role='toolbar'>";
        $buttons .= '<div class="btn-group mr-2" role="group" aria-label="First group">';
        $buttons .= MenuItem::listMenuItems("admin_$tab");
        $buttons .= "</div>";
        $buttons .= "</div>";
        $this->html = drawPage([
            "heading" => "Admin Dashboard",
            "body" => $body,
            "button" => $buttons,
            "layout" => $layout,
            "sidebar" => $sidebar,
            "breadcrumbs" => $breadcrumbs,
        ]);
    }

}
