<?php

namespace Chuckbe\Chuckcms\Actions\Menus;

use Chuckbe\Chuckcms\Models\MenuItems;
use Chuckbe\Chuckcms\Requests\Menus\AddCustomMenuItemRequest;

class AddCustomMenuItemAction
{
    public function __invoke(AddCustomMenuItemRequest $request): MenuItems
    {
        $menuId = $request->input('idmenu');

        $menuItem = new MenuItems();
        $menuItem->label = $request->input('labelmenu');
        $menuItem->link = $request->input('linkmenu');
        $menuItem->menu = $menuId;
        $menuItem->sort = MenuItems::getNextSortRoot($menuId);
        $menuItem->save();

        return $menuItem;
    }
}
