<?php

namespace Chuckbe\Chuckcms\Actions\Pages;

use Chuckbe\Chuckcms\Models\Page;

class MovePageAction
{
    public const DIRECTION_UP = 'up';
    public const DIRECTION_DOWN = 'down';
    public const DIRECTION_FIRST = 'first';
    public const DIRECTION_LAST = 'last';

    public function __invoke(int $pageId, string $direction): Page
    {
        $page = Page::findOrFail($pageId);

        match ($direction) {
            self::DIRECTION_UP    => $page->moveOrderUp(),
            self::DIRECTION_DOWN  => $page->moveOrderDown(),
            self::DIRECTION_FIRST => $page->moveToStart(),
            self::DIRECTION_LAST  => $page->moveToEnd(),
        };

        $page->save();

        return $page;
    }
}
