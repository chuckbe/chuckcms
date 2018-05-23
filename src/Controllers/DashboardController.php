<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;

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
        
        return view('chuckcms::backend.dashboard.index', compact('template', 'front_template'));
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
        
        return view('chuckcms::backend.pages.index', compact('template', 'front_template', 'pages'));
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
        return view('chuckcms::backend.pages.edit', compact('template', 'templates', 'page'));
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
        return view('chuckcms::backend.pages.create', compact('template', 'templates', 'page'));
    }

    /**
     * Show the dashboard -> page edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageSave(Request $request)
    {
        $this->validate(request(), [ //@todo create custom Request class for page validation
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
        $page = $this->page->getByIdWithBlocks($page_id);
        $template = $this->template->where('id', $page->template_id)->where('type', 'default')->first();
        $block_dir = array_slice(scandir('chuckbe/chuckcms/blocks/chuckv2/'), 2);
        $blocks = [];
        foreach($block_dir as $block){
            if((strpos($block, '.html') !== false)){
                $blockname = 
                $blocks[] = array(
                    'name' => str_replace('.html', '', $block),
                    'location' => 'chuckbe/chuckcms/blocks/chuckv2/'.$block,
                    'img' => 'chuckbe/chuckcms/blocks/chuckv2/'.str_replace('.html', '.jpg', $block)
                );
            }
        }
        //dd($blocks);
        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($this->pageblock->getAllByPageId($page->id));
        return view('chuckcms::backend.pages.pagebuilder.index', compact('template', 'page', 'pageblocks', 'blocks'));
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
        
        return view('chuckcms::backend.menus.index', compact('template', 'front_template', 'pages'));
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
        
        
        return view('chuckcms::backend.templates.index', compact('template', 'all_templates', 'pages'));
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
        
        return view('chuckcms::backend.users.index', compact('template', 'front_template', 'users'));
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
        
        return view('chuckcms::backend.settings.index', compact('template', 'front_template', 'pages'));
    }
}
