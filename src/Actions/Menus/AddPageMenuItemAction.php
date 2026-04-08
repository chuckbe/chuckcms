<?php

namespace Chuckbe\Chuckcms\Actions\Menus;

use Chuckbe\Chuckcms\Models\MenuItems;
use Chuckbe\Chuckcms\Requests\Menus\AddPageMenuItemRequest;

class AddPageMenuItemAction
{
    public function __invoke(AddPageMenuItemRequest $request): MenuItems
    {
        $menuId = $request->input('idmenu');

        $menuItem = new MenuItems();
        $menuItem->label = $request->input('labelmenu');
        $menuItem->link = 'page:'.$request->input('linkmenu');
        $menuItem->menu = $menuId;
        $menuItem->sort = MenuItems::getNextSortRoot($menuId);
        $menuItem->save();

        return $menuItem;
    }
}
