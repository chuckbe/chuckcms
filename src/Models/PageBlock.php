<?php

namespace Chuckbe\Chuckcms\Models;

use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;

use Eloquent;

class PageBlock extends Eloquent
{
    public function page()
    {
        return $this->belongsTo('Chuckbe\Chuckcms\Models\Page');
    }

    public function getAllByPageId($page_id)
    {
        $pageblocks = $this->where('page_id', $page_id)->orderBy('order', 'asc')->get();
        return $pageblocks;
    }

    public function getRenderedById($pageblock_id, PageBlockRepository $pageBlockRepository)
    {
    	$pageblock = $this->where('id', $pageblock_id)->first();
    	$new_pageblock = $pageBlockRepository->getRenderedByPageBlock($pageblock);
    	return $new_pageblock;
    }

    public function getById($id)
    {
        return $this->find($id);
    }

    public function getCountByPageId($page_id)
    {
        return $this->where('page_id', $page_id)->count();
    }



    public function moveUpById($id)//@todo add to pageblock repository
    {
        $pageblock = $this->find($id);
        $og_order = $pageblock->order;
        $target_pb = $this->where('page_id', $pageblock->page_id)->where('order', ($og_order - 1))->first();

        $pageblock->order = $og_order - 1;
        $target_pb->order = $og_order;

        $pageblock->update();
        $target_pb->update();
        return $this->getRenderedById($pageblock->id);
    }

    public function moveDownById($id)//@todo add to pageblock repository
    {
        $pageblock = $this->find($id);
        $og_order = $pageblock->order;
        $target_pb = $this->where('page_id', $pageblock->page_id)->where('order', ($og_order + 1))->first();

        $pageblock->order = $og_order + 1;
        $target_pb->order = $og_order;

        $pageblock->update();
        $target_pb->update();
        return $this->getRenderedById($pageblock->id);
    }

    public function moveOrderDownByPageId($id)//@todo add to pageblock repository
    {
        $pageblocks = $this->where('page_id', $id)->increment('order');
    }

    public function addBlockTop($contents, $page, $name)//@todo add to pageblock repository
    {
        $this->moveOrderDownByPageId($page->id);
        $pageblock = new PageBlock();
        $pageblock->page_id = $page->id;
        $pageblock->name = $name;
        $pageblock->slug = $name;
        $pageblock->body = $contents;
        $pageblock->order = 1;
        $pageblock->save();
        return $pageblock;
    }

    public function addBlockBottom($contents, $page, $name)//@todo add to pageblock repository
    {
        $pageblock = new PageBlock();
        $pageblock->page_id = $page->id;
        $pageblock->name = $name;
        $pageblock->slug = $name;
        $pageblock->body = $contents;
        $pageblock->order = $this->getCountByPageId($page->id) + 1;
        $pageblock->save();
        return $pageblock;
    }
}
