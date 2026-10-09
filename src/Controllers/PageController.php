<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Pages\CreatePageAction;
use Chuckbe\Chuckcms\Actions\Pages\DeletePageAction;
use Chuckbe\Chuckcms\Actions\Pages\MovePageAction;
use Chuckbe\Chuckcms\Actions\Pages\UpdatePageAction;
use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Chuck\Support\TemplateBlocks;
use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Requests\Pages\DeletePageRequest;
use Chuckbe\Chuckcms\Requests\Pages\SavePageRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class PageController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        private Page $page,
        private PageBlock $pageblock,
        private PageBlockRepository $pageBlockRepository,
        private Template $template,
    ) {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pages = $this->page->ordered()->get();

        return view('chuckcms::backend.pages.index', compact('pages'));
    }

    /**
     * Show the dashboard -> page create.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $templates = $this->template->where('active', 1)->get();
        $pageViews = $this->template->getPageViews();

        return view('chuckcms::backend.pages.create', compact('templates', 'pageViews'));
    }

    /**
     * Show the dashboard -> page edit.
     *
     * @return \Illuminate\View\View
     */
    public function edit($page_id)
    {
        $templates = $this->template->where('active', 1)->get();
        $page = $this->page->getByIdWithBlocks($page_id);
        $pageViews = $this->template->getPageViews();
        $roles = Role::all();

        return view('chuckcms::backend.pages.edit', compact('templates', 'page', 'pageViews', 'roles'));
    }

    /**
     * Create or update a page depending on which form field was
     * submitted. Dispatches to CreatePageAction or UpdatePageAction.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SavePageRequest $request, CreatePageAction $createPage, UpdatePageAction $updatePage)
    {
        if ($request['create']) {
            $createPage($request);
        }
        if ($request['update']) {
            $updatePage($request);
        }

        return redirect()->route('dashboard.pages');
    }

    /**
     * Delete the page and its page-blocks.
     */
    public function delete(DeletePageRequest $request, DeletePageAction $deletePage): string
    {
        return $deletePage($request);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveUp(MovePageAction $movePage, $page_id)
    {
        $movePage((int) $page_id, MovePageAction::DIRECTION_UP);

        return redirect()->route('dashboard.pages');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveFirst(MovePageAction $movePage, $page_id)
    {
        $movePage((int) $page_id, MovePageAction::DIRECTION_FIRST);

        return redirect()->route('dashboard.pages');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveDown(MovePageAction $movePage, $page_id)
    {
        $movePage((int) $page_id, MovePageAction::DIRECTION_DOWN);

        return redirect()->route('dashboard.pages');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveLast(MovePageAction $movePage, $page_id)
    {
        $movePage((int) $page_id, MovePageAction::DIRECTION_LAST);

        return redirect()->route('dashboard.pages');
    }

    /**
     * Show the dashboard -> page edit page builder.
     *
     * @return \Illuminate\View\View
     */
    public function builderIndex(Request $request, $page_id)
    {
        if ($request->has('lang')) {
            app()->setLocale($request->get('lang'));
        } else {
            return redirect()->to(URL::current().'?lang='.app()->getLocale());
        }
        $page = $this->page->getByIdWithBlocks($page_id);
        $template = $this->template->where('id', $page->template_id)->first();
        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($this->pageblock->getAllByPageId($page->id));

        $blocks = TemplateBlocks::scan($template->path.'/blocks');

        return view('chuckcms::backend.pages.pagebuilder.index', compact('template', 'page', 'pageblocks', 'blocks'));
    }

    /**
     * Return the raw page - ready for the builder.
     *
     * @return \Illuminate\View\View
     */
    public function builderRaw(Request $request, $page_id)
    {
        if ($request->has('lang')) {
            app()->setLocale($request->get('lang'));
        } else {
            return redirect()->to(URL::current().'?lang='.app()->getLocale());
        }
        $page = $this->page->getByIdWithBlocks($page_id);
        $template = $this->template->where('id', $page->template_id)->first();
        $pageblocks = $this->pageBlockRepository->getRenderedByPageBlocks($this->pageblock->getAllByPageId($page->id));

        return view('chuckcms::backend.pages.pagebuilder.core', compact('template', 'page', 'pageblocks'));
    }
}
