<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\PageBlocks\AddPageBlockAction;
use Chuckbe\Chuckcms\Actions\PageBlocks\DeletePageBlockAction;
use Chuckbe\Chuckcms\Actions\PageBlocks\MovePageBlockAction;
use Chuckbe\Chuckcms\Actions\PageBlocks\RenderPageBlockAction;
use Chuckbe\Chuckcms\Actions\PageBlocks\UpdatePageBlockBodyAction;
use Chuckbe\Chuckcms\Requests\PageBlocks\AddPageBlockRequest;
use Chuckbe\Chuckcms\Requests\PageBlocks\PageBlockIdRequest;
use Chuckbe\Chuckcms\Requests\PageBlocks\UpdatePageBlockBodyRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PageBlockController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function show(PageBlockIdRequest $request, RenderPageBlockAction $renderPageBlock): array
    {
        return $renderPageBlock($request);
    }

    public function update(UpdatePageBlockBodyRequest $request, UpdatePageBlockBodyAction $updateBody): array
    {
        return $updateBody($request);
    }

    public function moveUp(PageBlockIdRequest $request, MovePageBlockAction $movePageBlock): array
    {
        return $movePageBlock($request, MovePageBlockAction::DIRECTION_UP);
    }

    public function moveDown(PageBlockIdRequest $request, MovePageBlockAction $movePageBlock): array
    {
        return $movePageBlock($request, MovePageBlockAction::DIRECTION_DOWN);
    }

    public function delete(PageBlockIdRequest $request, DeletePageBlockAction $deletePageBlock): string
    {
        return $deletePageBlock($request);
    }

    public function addBlockTop(AddPageBlockRequest $request, AddPageBlockAction $addPageBlock): string
    {
        if ($request->has('lang')) {
            app()->setLocale($request->get('lang'));
        }

        $addPageBlock($request, AddPageBlockAction::POSITION_TOP);

        return 'success';
    }

    public function addBlockBottom(AddPageBlockRequest $request, AddPageBlockAction $addPageBlock): string
    {
        if ($request->has('lang')) {
            app()->setLocale($request->get('lang'));
        }

        $addPageBlock($request, AddPageBlockAction::POSITION_BOTTOM);

        return 'success';
    }
}
