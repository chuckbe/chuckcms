<?php

namespace Chuckbe\Chuckcms\Actions\Menus;

use Chuckbe\Chuckcms\Models\MenuItems;
use Chuckbe\Chuckcms\Requests\Menus\UpdateMenuItemRequest;

class UpdateMenuItemAction
{
    /**
     * Update one or many menu items depending on payload shape:
     * - arraydata[]: batch update from the drag-and-drop builder
     * - id/label/url/clases: single-item update
     */
    public function __invoke(UpdateMenuItemRequest $request): void
    {
        $batch = $request->input('arraydata');
        if (is_array($batch)) {
            $this->applyBatch($batch);

            return;
        }

        $this->applySingle($request);
    }

    private function applyBatch(array $items): void
    {
        foreach ($items as $item) {
            $menuItem = MenuItems::find($item['id'] ?? null);
            if ($menuItem === null) {
                continue;
            }
            $menuItem->label = $item['label'] ?? $menuItem->label;
            $menuItem->link = $item['link'] ?? $menuItem->link;
            $menuItem->class = $item['class'] ?? $menuItem->class;
            $menuItem->save();
        }
    }

    private function applySingle(UpdateMenuItemRequest $request): void
    {
        $menuItem = MenuItems::find($request->input('id'));
        if ($menuItem === null) {
            return;
        }
        $menuItem->label = $request->input('label');
        $menuItem->link = $request->input('url');
        $menuItem->class = $request->input('clases');
        $menuItem->save();
    }
}
