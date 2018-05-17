<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Template;

use File;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageBlockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Template $template, Page $page, PageBlock $pageblock, PageBlockRepository $pageBlockRepository, Resource $resource, Repeater $repeater)
    {
        $this->template = $template;
        $this->page = $page;
        $this->pageblock = $pageblock;
        $this->pageBlockRepository = $pageBlockRepository;
        $this->resource = $resource;
        $this->repeater = $repeater;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $pageblock = $this->pageblock->getRenderedById($request->get('pageblock_id'));
        return $pageblock;
    }

    /**
     * Add a block to the top of the page.
     *
     * @return \Illuminate\Http\Response
     */
    public function addBlockTop()
    {
        // AUTHORIZE ... COMES HERE
        $contents = File::get('blocks/chuckv1/content-three-cols.html');
        $page = $this->page->getById(1);
        $pageblock = $this->pageblock->addBlockTop($contents, $page);
        return $pageblock;
    }

    /**
     * Show the application dashboard.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $pageblock = $this->pageblock->getById($request->get('pageblock_id'));
        $pageblock = $this->pageBlockRepository->updateBody($pageblock, $request->get('html'));
        return $pageblock;
    }

    /**
     * Move the resource one place up.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function moveUp(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $pageblock = $this->pageBlockRepository->moveUpById($request->get('pageblock_id'));
        return $pageblock;
    }

    /**
     * Move the resource one place down.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function moveDown(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $pageblock = $this->pageBlockRepository->moveDownById($request->get('pageblock_id'));
        return $pageblock;
    }
}
