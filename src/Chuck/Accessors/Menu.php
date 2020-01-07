<?php

namespace Chuckbe\Chuckcms\Chuck\Accessors;

use App\Http\Requests;
use Chuckbe\Chuckcms\Models\Menus;
use Chuckbe\Chuckcms\Models\MenuItems;

class Menu
{
    public function render($pages)
    {
        $menu = new Menus();
        $menuitems = new MenuItems();
        $menulist = $menu->select(['id', 'name'])->get();
        $menulist = $menulist->pluck('name', 'id')->prepend('Select menu', 0)->all();

        if ((request()->has("action") && empty(request()->input("menu"))) || request()->input("menu") == '0') {
            return view('chuckcms::vendor.chuck-menu.menu-dashboard')->with("menulist", $menulist);
        } else {

            $menu = Menus::find(request()->input("menu"));
            $menus = $menuitems->getall(request()->input("menu"));

            $data = ['menus' => $menus, 'indmenu' => $menu, 'menulist' => $menulist, 'pages' => $pages];
            return view('chuckcms::vendor.chuck-menu.menu-dashboard', $data);
        }

    }

    public function renderFrontEnd($tslug = null, $fileslug = null, $menuname = null)
    {
        if ($menuslug == null) {
            $menu = Menus::find(1);
        } else {
            $menu = Menus::where('name', $menuslug)->first();
        }
        
        $menuitems = new MenuItems();
        $menus = $menuitems->getall(1);

        $data = ['menus' => $menus, 'indmenu' => $menu];
        if ($tslug == null) {
            return view('chuckcms::vendor.chuck-menu.menu-front-end', $data);
        }
        if ($fileslug == null) {
            return view($tslug . '::vendor.chuck-menu.menu-front-end', $data);
        }
        return view($tslug . '::vendor.chuck-menu.' . $fileslug, $data);
    }

    public function scripts()
    {
        return view('chuckcms::vendor.chuck-menu.scripts');
    }

    public function select($name = "menu", $menulist = array())
    {
        $html = '<select name="' . $name . '">';

        foreach ($menulist as $key => $val) {
            $active = '';
            if (request()->input('menu') == $key) {
                $active = 'selected="selected"';
            }
            $html .= '<option ' . $active . ' value="' . $key . '">' . $val . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public static function getByName($name)
    {
        $menu_id = Menus::byName($name)->id;
        return self::get($menu_id);
    }

    public static function get($menu_id)
    {
        $menuItem = new MenuItems;
        $menu_list = $menuItem->getall($menu_id);

        $roots = $menu_list->where('menu', (integer)$menu_id)->where('parent', 0);

        $items = self::tree($roots, $menu_list);
        return $items;
    }

    private static function tree($items, $all_items)
    {
        $data_arr = array();
        $i = 0;
        foreach ($items as $item) {
            $data_arr[$i] = $item->toArray();
            $find = $all_items->where('parent', $item->id);

            $data_arr[$i]['child'] = array();

            if ($find->count()) {
                $data_arr[$i]['child'] = self::tree($find, $all_items);
            }

            $i++;
        }

        return $data_arr;
    }

}
