<?php

namespace Chuckbe\Chuckcms\Actions\PageBlocks;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Requests\PageBlocks\AddPageBlockRequest;
use Illuminate\Support\Facades\File;

class AddPageBlockAction
{
    public const POSITION_TOP = 'top';
    public const POSITION_BOTTOM = 'bottom';

    public function __construct(private ResolveBlockLocationAction $resolveBlockLocation)
    {
    }

    public function __invoke(AddPageBlockRequest $request, string $position): PageBlock
    {
        $contents = File::get(($this->resolveBlockLocation)($request->input('location')));
        $page = Page::findOrFail($request->input('page_id'));
        $name = $request->input('name');

        return match ($position) {
            self::POSITION_TOP    => $this->addTop($contents, $page, $name),
            self::POSITION_BOTTOM => $this->addBottom($contents, $page, $name),
        };
    }

    private function addTop(string $contents, Page $page, string $name): PageBlock
    {
        // Everything after the new block shifts down by one.
        PageBlock::where('page_id', $page->id)
            ->where('lang', app()->getLocale())
            ->increment('order');

        return $this->persistPageBlock($contents, $page, $name, order: 1);
    }

    private function addBottom(string $contents, Page $page, string $name): PageBlock
    {
        $nextOrder = PageBlock::where('page_id', $page->id)
            ->where('lang', app()->getLocale())
            ->count() + 1;

        return $this->persistPageBlock($contents, $page, $name, order: $nextOrder);
    }

    private function persistPageBlock(string $contents, Page $page, string $name, int $order): PageBlock
    {
        $block = new PageBlock();
        $block->page_id = $page->id;
        $block->name = $name;
        $block->slug = $name;
        $block->body = $contents;
        $block->order = $order;
        $block->lang = app()->getLocale();
        $block->save();

        return $block;
    }
}
