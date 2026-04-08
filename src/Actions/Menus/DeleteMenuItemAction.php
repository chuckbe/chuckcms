<?php

namespace Chuckbe\Chuckcms\Actions\Menus;

use Chuckbe\Chuckcms\Models\MenuItems;
use Chuckbe\Chuckcms\Requests\Menus\DeleteMenuItemRequest;

class DeleteMenuItemAction
{
    public function __invoke(DeleteMenuItemRequest $request): bool
    {
        $menuItem = MenuItems::find($request->input('id'));
        if ($menuItem === null) {
            return false;
        }

        return (bool) $menuItem->delete();
    }
}
