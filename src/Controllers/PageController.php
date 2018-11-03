<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\PageBlockRepository;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Models\Template;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    private $page;
    private $pageblock;
    private $pageBlockRepository;
    private $redirect;
    private $template;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Page $page, PageBlock $pageblock, PageBlockRepository $pageBlockRepository, Redirect $redirect, Template $template)
    {
        $this->page = $page;
        $this->pageblock = $pageblock;
        $this->pageBlockRepository = $pageBlockRepository;
        $this->redirect = $redirect;
        $this->template = $template;
    }

    public function index($slug = null)
    {
        if($slug == null){
            $page = $this->page->where('isHp', 1)->firstOrFail();
        } elseif($slug !== null){
            $redirect = $this->redirect->where('slug', $slug)->first();
            if($redirect !== null){
                return redirect($redirect->to, $redirect->type);
            }
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
        
        return view($template->hintpath.'::templates.'.$template->slug.'.page', compact('template', 'page', 'pageblocks'));
    }
}
