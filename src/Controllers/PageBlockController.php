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

    /**
     * Delete the resource from the page.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $status = $this->pageBlockRepository->deleteById($request->get('pageblock_id'));
        return $status;
    }

    /**
     * Add Block From Location To Top of Page and Store to Database
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function addBlockTop(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $contents = File::get($request['location']);
        $page = $this->page->getById($request['page_id']);
        $pageblock = $this->pageblock->addBlockTop($contents, $page, $request['name']);
        //return $pageblock;
        return 'success';
    }

    /**
     * Add Block From Location To Bottom of Page and Store to Database
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function addBlockBottom(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $contents = File::get($request['location']);
        $page = $this->page->getById($request['page_id']);
        $pageblock = $this->pageblock->addBlockTop($contents, $page);
        //return $pageblock;
        return 'success';
    }
}
