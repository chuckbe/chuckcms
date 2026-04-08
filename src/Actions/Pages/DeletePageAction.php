<?php

namespace Chuckbe\Chuckcms\Actions\Pages;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Requests\Pages\DeletePageRequest;

class DeletePageAction
{
    /**
     * Delete a page and its page-blocks.
     *
     * Returns the legacy tri-state string the frontend JS still expects:
     *   'success' — page was found and deleted
     *   'error'   — page was found but the delete() call returned false
     *   'false'   — page_id was not resolvable to an existing page
     */
    public function __invoke(DeletePageRequest $request): string
    {
        $page = Page::find($request->input('page_id'));
        if ($page === null) {
            return 'false';
        }

        PageBlock::where('page_id', $page->id)->delete();

        return $page->delete() ? 'success' : 'error';
    }
}
