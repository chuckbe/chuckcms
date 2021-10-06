<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected $template;
    protected $site;
    protected $page;
    protected $pageblock;
    protected $pageBlockRepository;
    protected $resource;
    protected $repeater;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Template $template, Site $site, Page $page, PageBlock $pageblock, PageBlockRepository $pageBlockRepository, Resource $resource, Repeater $repeater, User $user)
    {
        $this->template = $template;
        $this->site = $site;
        $this->page = $page;
        $this->pageblock = $pageblock;
        $this->pageBlockRepository = $pageBlockRepository;
        $this->resource = $resource;
        $this->repeater = $repeater;
        $this->user = $user;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('chuckcms::backend.dashboard.index');
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        $pages = $this->page->get();
        $site = $this->site->first(); //change method to get active site

        return view('chuckcms::backend.settings.index', compact('pages', 'site'));
    }
}
