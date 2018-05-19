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

    public function index($slug = null)
    {
        if($slug == null){
            $page = $this->page->where('isHp', 1)->first();
            $slug = $page->slug;
        } elseif($slug !== null){
            $slug = $slug;
            $page = $this->page->where('slug->'.app()->getLocale(), $slug)->first();
            if($page == null){
               foreach(\LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
                    $page = $this->page->where('slug->'.$localeCode, $slug)->first();
                    if($page !== null && $localeCode == app()->getLocale()) break;

                    if($page !== null && $localeCode !== app()->getLocale()){
                        //dd(app()->getLocale());
                        app()->setLocale($localeCode); 
                        \LaravelLocalization::setLocale($localeCode);
                        
                        return redirect($localeCode.'/'.$slug);
                    } 
                } 
            }
            if($page == null) abort(404);
        }
        
        
        $ogpageblocks = $this->pageblock->getAllByPageId($page->id);
        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($ogpageblocks);
        $template = $this->template->where('active', 1)->where('id', $page->template_id)->first();
        
        return view('chuckcms::templates.'.$template->slug.'.page', compact('template', 'page', 'pageblocks'));
    }
}
