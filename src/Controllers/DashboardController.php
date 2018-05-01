<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Template;

use App\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Template $template, Page $page, PageBlock $pageblock, PageBlockRepository $pageBlockRepository, Resource $resource, Repeater $repeater, User $user)
    {
        $this->template = $template;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $front_template = $this->template->where('active', 1)->where('type', 'default')->where('slug', $template->slug)->first();
        
        return view('chuckcms::templates.'.$template->slug.'.dashboard.dashboard', compact('template', 'front_template'));
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function pages()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $front_template = $this->template->where('active', 1)->where('type', 'default')->where('slug', $template->slug)->first();
        $pages = $this->page->get();
        
        return view('chuckcms::templates.'.$template->slug.'.dashboard.pages', compact('template', 'front_template', 'pages'));
    }

    /**
     * Show the dashboard -> page edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageEdit($page_id)
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $templates = $this->template->where('active', 1)->where('type', 'default')->get();
        $page = $this->page->getByIdWithBlocks($page_id);
        return view('chuckcms::templates.'.$template->slug.'.dashboard.pages.edit', compact('template', 'templates', 'page'));
    }

    /**
     * Show the dashboard -> page create.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageCreate()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $templates = $this->template->where('active', 1)->where('type', 'default')->get();
        return view('chuckcms::templates.'.$template->slug.'.dashboard.pages.create', compact('template', 'templates', 'page'));
    }

    /**
     * Show the dashboard -> page edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageSave(Request $request)
    {
        $this->validate(request(), [
            'page_title' => 'max:185',
        ]);
        if($request['create']){
            $page = $this->page->create($request);
        } if($request['update']){
            $page = $this->page->updatePage($request);
        }
        return redirect()->route('dashboard.pages');
    }

    /**
     * Show the dashboard -> page edit page builder.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageEditBuilder($page_id)
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $page = $this->page->getByIdWithBlocks($page_id);

        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($this->pageblock->getAllByPageId($page->id));
        return view('chuckcms::templates.'.$template->slug.'.dashboard.pages.pagebuilder', compact('template', 'page', 'pageblocks'));
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function menus()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $front_template = $this->template->where('active', 1)->where('type', 'default')->where('slug', $template->slug)->first();
        $pages = $this->page->get();
        
        return view('chuckcms::templates.'.$template->slug.'.dashboard.menus', compact('template', 'front_template', 'pages'));
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function templates()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $all_templates = $this->template->where('active', 1)->where('type', 'default')->get();
        $pages = $this->page->get();
        
        
        return view('chuckcms::templates.'.$template->slug.'.dashboard.templates', compact('template', 'all_templates', 'pages'));
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $front_template = $this->template->where('active', 1)->where('type', 'default')->where('slug', $template->slug)->first();
        $users = $this->user->get();
        
        return view('chuckcms::templates.'.$template->slug.'.dashboard.users', compact('template', 'front_template', 'users'));
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $front_template = $this->template->where('active', 1)->where('type', 'default')->where('slug', $template->slug)->first();
        $pages = $this->page->get();
        
        return view('chuckcms::templates.'.$template->slug.'.dashboard.settings', compact('template', 'front_template', 'pages'));
    }
}
