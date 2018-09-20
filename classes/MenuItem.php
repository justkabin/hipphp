<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class MenuItem {

    public function __construct($params = []) {
        $exists = false;
        $defaults = [
            "weight" => 0,
            "title" => null
        ];
        $params = array_merge($defaults, $params);
        $menus = self::getMenuItemsFromCache();
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $this->$key = $value;
            }
        }
        if (!empty($menus)) {
            foreach ($menus as $menu) {
                if ($menu->name == $params['name']) {
                    $exists = true;
                }
            }
        }

        if (!$exists) {
            $menus[] = $this;
            self::saveMenuItemsToCache($menus);
        }
    }

    static function remove($name) {
        $return = false;
        $items = self::getMenuItemsFromCache();
        foreach ($items as $key => $item) {
            if ($item->name == $name) {
                $return = $item;
                unset($items[$key]);
            }
        }
        self::saveMenuItemsToCache($items);
        return $return;
    }

    static private function saveMenuItemsToCache($menus) {
        Cache::set("menus", $menus, "session");
    }

    static private function getMenuItemsFromCache() {
        $return = Cache::get("menus", "session");
        if ($return) {
            return $return;
        }
        return [];
    }

    static function getMenuItems($menu = "header_left") {
        $return = [];
        $items = self::getMenuItemsFromCache();
        if (!empty($items)) {
            foreach ($items as $item) {
                if ($item->menu == $menu) {
                    $return[] = $item;
                }
            }
        }
        return $return;
    }

    static function listMenuItems($menu = "header_left", $list_class = "nav-item", $element = "li", $dropdown = false) {
        $return = null;
        $items = self::getMenuItems($menu);
        usort($items, "array_of_objects_sorter");
        foreach ($items as $item) {
            $url = isset($item->url) ? $item->url : $item->name;
            $active = $url == urlString() ? " active " : "";
            $link_class = isset($item->link_class) ? $item->link_class : "nav-link";
            $dropdown_class = ($dropdown) ? " dropdown-item" : "";
            $label = $item->label;
            if ($url != "#") {
                $url = normalizeURL($url);
                if (!$dropdown) {
                    $return .= <<<HTML
<{$element} class="$list_class $dropdown_class{$active}">
    <a class="$link_class{$active}" href="{$url}"  title="{$item->title}" data-selector="true">$label</a>
</{$element}>
HTML;
                } else {
                    $return .= <<<HTML
<a class="$link_class{$active}" href="$url">$label</a>
HTML;
                }
            } else {
                $submenu = self::listMenuItems($item->name, "nav-item", "a", true);
                $return .= <<<HTML
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        $label
    </a>
    <div class="dropdown-menu">
        $submenu
    </div>
</li>
HTML;
            }
        }
        return $return;
    }

    public function update() {
        $items = self::getMenuItemsFromCache();
        $items[] = $this;
        self::saveMenuItemsToCache($items);
        return;
    }

}
