<?php

namespace Chuckbe\Chuckcms\Actions\PageBlocks;

use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Requests\PageBlocks\PageBlockIdRequest;

class DeletePageBlockAction
{
    /**
     * Delete a page-block and close the order gap it leaves behind.
     *
     * Returns the legacy 'success'/'error'/'false' tri-state string.
     */
    public function __invoke(PageBlockIdRequest $request): string
    {
        $pageblock = PageBlock::find($request->input('pageblock_id'));
        if ($pageblock === null) {
            return 'false';
        }

        // Shift subsequent siblings in the same page + locale up by one.
        PageBlock::where('page_id', $pageblock->page_id)
            ->where('lang', $pageblock->lang)
            ->where('order', '>', $pageblock->order)
            ->decrement('order');

        return $pageblock->delete() ? 'success' : 'error';
    }
}
