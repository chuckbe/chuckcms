<?php

namespace Chuckbe\Chuckcms\Actions\Menus;

use Chuckbe\Chuckcms\Models\Menus;
use Chuckbe\Chuckcms\Requests\Menus\CreateMenuRequest;

class CreateMenuAction
{
    public function __invoke(CreateMenuRequest $request): Menus
    {
        $menu = new Menus();
        $menu->name = $request->input('menuname');
        $menu->save();

        return $menu;
    }
}
