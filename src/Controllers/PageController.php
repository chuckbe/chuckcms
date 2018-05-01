<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\Template;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    private $page;
    private $pageblock;
    private $pageBlockRepository;
    private $template;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Page $page, PageBlock $pageblock, PageBlockRepository $pageBlockRepository, Template $template)
    {
        $this->page = $page;
        $this->pageblock = $pageblock;
        $this->pageBlockRepository = $pageBlockRepository;
        $this->template = $template;
    }

    public function index($slug = null, $slugger = null)
    {
        if($slug == null){
            $slug = 'thuis';
        } elseif($slug !== null && $slugger !== null) {
            $slug = $slug . '/' . $slugger;
        } elseif($slug !== null){
            $slug = $slug;
        }
        
        $page = $this->page->where('slug', $slug)->first();

        if($page == null) return redirect()->route('page', ['slug' => 'thuis']);
        
        $ogpageblocks = $this->pageblock->getAllByPageId($page->id);
        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($ogpageblocks);
        $template = $this->template->where('active', 1)->where('id', $page->template_id)->first();
        
        return view('chuckcms::templates.'.$template->slug.'.page', compact('template', 'page', 'pageblocks'));
    }
}
