<?php

namespace Chuckbe\Chuckcms\Actions\Menus;

use Chuckbe\Chuckcms\Models\MenuItems;
use Chuckbe\Chuckcms\Models\Menus;
use Chuckbe\Chuckcms\Requests\Menus\DeleteMenuRequest;

class DeleteMenuAction
{
    public const RESULT_DELETED = 'deleted';
    public const RESULT_HAS_ITEMS = 'has_items';
    public const RESULT_NOT_FOUND = 'not_found';

    /**
     * Delete a menu only if it has no items. Matches the legacy
     * guard that counted items first and refused to delete otherwise.
     */
    public function __invoke(DeleteMenuRequest $request): string
    {
        $id = $request->input('id');

        if (MenuItems::where('menu', $id)->exists()) {
            return self::RESULT_HAS_ITEMS;
        }

        $menu = Menus::find($id);
        if ($menu === null) {
            return self::RESULT_NOT_FOUND;
        }

        $menu->delete();

        return self::RESULT_DELETED;
    }
}
