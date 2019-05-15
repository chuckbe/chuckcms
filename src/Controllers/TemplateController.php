<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\Template;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TemplateController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $page;
    protected $template;
    
    /**
     * Create a TemplateController instance.
     *
     * @return void
     */
    public function __construct(Page $page, Template $template)
    {
        $this->page = $page;
        $this->template = $template;
    }

    /**
     * Show the dashboard -> templates > index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $templates = $this->template->where('active', 1)->get();
        
        $pages = $this->page->get();
        
        return view('chuckcms::backend.templates.index', compact('templates', 'pages'));
    }

    /**
     * Show the dashboard -> templates > index
     *
     * @param  string $slug
     * 
     * @return \Illuminate\View\View
     */
    public function edit($slug)
    {
        $template = $this->template->where('active', 1)->where('slug', $slug)->first();
        
        return view('chuckcms::backend.templates.edit', compact('template'));
    }

    /**
     * Show the dashboard -> templates > index
     *
     * @param  Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'template_id' => 'required',
        ]);
    
        $this->template->updateFromRequest($request);
        
        return redirect()->route('dashboard.templates');
    }
}
