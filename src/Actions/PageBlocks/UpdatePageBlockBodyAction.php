<?php

namespace Chuckbe\Chuckcms\Actions\PageBlocks;

use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Requests\PageBlocks\UpdatePageBlockBodyRequest;

class UpdatePageBlockBodyAction
{
    public function __construct(private PageBlockRepository $pageBlockRepository)
    {
    }

    public function __invoke(UpdatePageBlockBodyRequest $request): array
    {
        $pageblock = PageBlock::findOrFail($request->input('pageblock_id'));

        return $this->pageBlockRepository->updateBody($pageblock, $request->input('html'));
    }
}
