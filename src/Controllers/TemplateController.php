<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\Template;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    private $page;
    private $template;
    /**
     * Create a new controller instance.
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = $this->template->where('active', 1)->where('type', 'default')->get();
        
        $pages = $this->page->get();
        
        return view('chuckcms::backend.templates.index', compact('templates', 'pages'));
    }
}
