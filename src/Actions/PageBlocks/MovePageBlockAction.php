<?php

namespace Chuckbe\Chuckcms\Actions\PageBlocks;

use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Requests\PageBlocks\PageBlockIdRequest;

class MovePageBlockAction
{
    public const DIRECTION_UP = 'up';
    public const DIRECTION_DOWN = 'down';

    public function __construct(private PageBlockRepository $pageBlockRepository)
    {
    }

    public function __invoke(PageBlockIdRequest $request, string $direction): array
    {
        $pageblock = PageBlock::findOrFail($request->input('pageblock_id'));
        $originalOrder = $pageblock->order;

        $delta = $direction === self::DIRECTION_UP ? -1 : 1;
        $target = PageBlock::where('page_id', $pageblock->page_id)
            ->where('lang', $pageblock->lang)
            ->where('order', $originalOrder + $delta)
            ->firstOrFail();

        $pageblock->order = $originalOrder + $delta;
        $target->order = $originalOrder;
        $pageblock->update();
        $target->update();

        return $this->pageBlockRepository->getRenderedByPageBlock($pageblock);
    }
}
