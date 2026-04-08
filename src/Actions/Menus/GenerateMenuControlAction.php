<?php

namespace Chuckbe\Chuckcms\Actions\Menus;

use Chuckbe\Chuckcms\Models\MenuItems;
use Chuckbe\Chuckcms\Models\Menus;
use Chuckbe\Chuckcms\Requests\Menus\GenerateMenuControlRequest;

/**
 * Apply the full drag-and-drop re-layout of a menu: rename the menu
 * itself and persist each child's new parent/sort/depth tuple.
 */
class GenerateMenuControlAction
{
    public function __invoke(GenerateMenuControlRequest $request): void
    {
        $menu = Menus::find($request->input('idmenu'));
        if ($menu === null) {
            return;
        }
        $menu->name = $request->input('menuname');
        $menu->save();

        foreach ((array) $request->input('arraydata', []) as $item) {
            $menuItem = MenuItems::find($item['id'] ?? null);
            if ($menuItem === null) {
                continue;
            }
            $menuItem->parent = $item['parent'] ?? null;
            $menuItem->sort = $item['sort'] ?? 0;
            $menuItem->depth = $item['depth'] ?? 0;
            $menuItem->save();
        }
    }
}
