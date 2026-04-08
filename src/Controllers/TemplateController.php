<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Templates\SaveTemplateAction;
use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Requests\Templates\SaveTemplateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class TemplateController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Create a TemplateController instance.
     */
    public function __construct(
        protected Page $page,
        protected Template $template,
    ) {
    }

    /**
     * Show the dashboard -> templates > index.
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
     * Show the dashboard -> templates > index.
     *
     * @param string $slug
     *
     * @return \Illuminate\View\View
     */
    public function edit($slug)
    {
        $template = $this->template->where('active', 1)->where('slug', $slug)->first();

        return view('chuckcms::backend.templates.edit.index', compact('template'));
    }

    /**
     * Show the dashboard -> templates > index.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveTemplateRequest $request, SaveTemplateAction $saveTemplate)
    {
        $saveTemplate($request);

        return redirect()->route('dashboard.templates');
    }
}
