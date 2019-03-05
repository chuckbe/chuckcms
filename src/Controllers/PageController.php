<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\PageBlockRepository;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $page;
    private $pageblock;
    private $pageBlockRepository;
    private $redirect;
    private $resource;
    private $repeater;
    private $site;
    private $template;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Page $page, 
        PageBlock $pageblock, 
        PageBlockRepository $pageBlockRepository, 
        Redirect $redirect, 
        Resource $resource,
        Repeater $repeater, 
        Site $site, 
        Template $template,
        User $user)
    {
        $this->page = $page;
        $this->pageblock = $pageblock;
        $this->pageBlockRepository = $pageBlockRepository;
        $this->redirect = $redirect;
        $this->resource = $resource;
        $this->repeater = $repeater;
        $this->site = $site;
        $this->template = $template;
        $this->user = $user;
        $this->middleware('auth');
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pages = $this->page->get();
        
        return view('chuckcms::backend.pages.index', compact('pages'));
    }

    /**
     * Show the dashboard -> page edit.
     *
     * @return \Illuminate\View\View
     */
    public function edit($page_id)
    {
        $templates = $this->template->where('active', 1)->where('type', 'default')->get();
        $page = $this->page->getByIdWithBlocks($page_id);
        $pageViews = $this->template->getPageViews();
        return view('chuckcms::backend.pages.edit', compact('templates', 'page', 'pageViews'));
    }

    /**
     * Show the dashboard -> page create.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $templates = $this->template->where('active', 1)->where('type', 'default')->get();
        $pageViews = $this->template->getPageViews();
        return view('chuckcms::backend.pages.create', compact('template', 'templates', 'page', 'pageViews'));
    }

    /**
     * Show the dashboard -> page edit.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'page_title' => 'max:185',
        ]);
        if($request['create']){
            $this->page->create($request);
        } if($request['update']){
            $this->page->updatePage($request);
        }
        return redirect()->route('dashboard.pages');
    }

    /**
     * Delete the page and pageblocks.
     *
     * @return string $status
     */
    public function delete(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'page_id' => 'required',
        ]);
        
        $status = $this->page->deleteById($request->get('page_id'));
        return $status;
    }

    /**
     * Show the dashboard -> page edit page builder.
     *
     * @return \Illuminate\View\View
     */
    public function builderIndex($page_id)
    {
        $page = $this->page->getByIdWithBlocks($page_id);
        $template = $this->template->where('id', $page->template_id)->where('type', 'default')->first();
        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($this->pageblock->getAllByPageId($page->id));

        $block_dir = array_slice(scandir('chuckbe/' . $template->slug . '/blocks'), 2);        
        $blocks = $this->dirToArray($template->path . '/blocks');
        
        return view('chuckcms::backend.pages.pagebuilder.index', compact('template', 'page', 'pageblocks', 'blocks'));
    }

    public function dirToArray($dir) { 
   
        $result = array(); 

        $cdir = scandir($dir); 
        foreach ($cdir as $key => $value) 
        { 
            if (!in_array($value, array(".", ".."))) { 
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) { 
                    $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
                } 
                else { 
                    if ($value !== '.DS_Store' && (strpos($value, '.html') !== false)) {
                        $blockKey = str_replace('.html', '', $value);
                        $blockName = str_replace('-', ' ', $blockKey);
                        if (file_exists($dir . DIRECTORY_SEPARATOR . $blockKey . '.jpg')) {
                            $blockImage = $dir . DIRECTORY_SEPARATOR . $blockKey . '.jpg';
                        } elseif (file_exists($dir . DIRECTORY_SEPARATOR . $blockKey . '.jpeg')) {
                            $blockImage = $dir . DIRECTORY_SEPARATOR . $blockKey . '.jpeg';
                        } elseif (file_exists($dir . DIRECTORY_SEPARATOR . $blockKey . '.png')) {
                            $blockImage = $dir . DIRECTORY_SEPARATOR . $blockKey . '.png';
                        } else {
                            $blockImage = 'https://ui-avatars.com/api/?length=5&size=150&name=BLOCK&background=0D8ABC&color=fff&font-size=0.2';
                        }
                        $result[$blockKey] = array(
                            'name' => $blockName,
                            'location' => $dir . DIRECTORY_SEPARATOR . $value,
                            'img' => $blockImage
                        );
                    }
                } 
            } 
        } 

        return $result; 
    }

    /**
     * Return the raw page - ready for the builder
     *
     * @return \Illuminate\View\View
     */
    public function builderRaw($page_id)
    {
        $page = $this->page->getByIdWithBlocks($page_id);
        $template = $this->template->where('id', $page->template_id)->where('type', 'default')->first();
        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($this->pageblock->getAllByPageId($page->id));

        return view('chuckcms::backend.pages.pagebuilder.core', compact('template', 'page', 'pageblocks'));
    }
}
