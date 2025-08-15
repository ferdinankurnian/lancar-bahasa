<?php

use Modules\Menubuilder\app\Models\Menus;
use Modules\Menubuilder\app\Models\MenuItem;


if (! function_exists('menuGetBySlug')) {
    function menuGetBySlug($slug){
        $menu = Menus::bySlug($slug);
        return is_null($menu) ? [] : menuGetById($menu->id);
    }
}

if (! function_exists('menuGetByName')) {
    function menuGetByName($name){
        $menu = Menus::byName($name);
        return is_null($menu) ? [] : menuGetById($menu->id);
    }
}

if (! function_exists('menuGetById')) {
    function menuGetById($menu_id){
        $menuItem = new MenuItem;
        $menu_list = $menuItem->getAll($menu_id);

        $roots = $menu_list->where('menu_id', (integer) $menu_id)->where('parent_id', 0);

        $items = menuTree($roots, $menu_list);
        return $items;
    }
}

if (! function_exists('menuTree')) {
    function menuTree($items, $all_items){
        $data_arr = array();
        $i = 0;
        foreach ($items as $item) {
            $data_arr[$i] = $item->toArray();
            $find = $all_items->where('parent_id', $item->id);

            $data_arr[$i]['child'] = array();

            if ($find->count()) {
                $data_arr[$i]['child'] = menuTree($find, $all_items);
            }

            $i++;
        }

        return $data_arr;
    }
}
if (! function_exists('currectUrlWithQuery')) {
    function currectUrlWithQuery($code){
        $currentUrlWithQuery = request()->fullUrl();

        // Parse the query string
        $parsedQuery = parse_url($currentUrlWithQuery, PHP_URL_QUERY);

        // Check if the 'code' parameter already exists
        $codeExists = false;
        if ($parsedQuery) {
            parse_str($parsedQuery, $queryArray);
            $codeExists = isset($queryArray['code']);
        }

        if ($codeExists) {
            $updatedUrlWithQuery = preg_replace('/(\?|&)code=[^&]*/', '$1code=' . $code, $currentUrlWithQuery);
        } else {
            $updatedUrlWithQuery = $currentUrlWithQuery . ($parsedQuery ? '&' : '?') . http_build_query(['code' => $code]);
        }
        return $updatedUrlWithQuery;
    }
}