<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\PageRepository;
use Chuckbe\Chuckcms\Chuck\PageBlockRepository;
use Chuckbe\Chuckcms\Models\Page;
use Chuckbe\Chuckcms\Models\PageBlock;
use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Models\Repeater;
use Chuckbe\Chuckcms\Models\Resource;
use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;
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

    private $page;
    private $pageRepository;
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
        PageRepository $pageRepository,
        PageBlock $pageblock,
        PageBlockRepository $pageBlockRepository,
        Redirect $redirect,
        Resource $resource,
        Repeater $repeater,
        Site $site,
        Template $template,
        User $user
    ) {
        $this->page = $page;
        $this->pageRepository = $pageRepository;
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
     * Show the dashboard -> page edit.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'page_title' => 'max:185',
        ]);
        if ($request['create']) {
            $this->pageRepository->create($request);
        }
        if ($request['update']) {
            $this->pageRepository->updatePage($request);
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
     * Move up.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveUp($page_id)
    {
        $page = $this->page->getById($page_id);
        $page->moveOrderUp();
        $page->save();

        return redirect()->route('dashboard.pages');
    }

    /**
     * Move first.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveFirst($page_id)
    {
        $page = $this->page->getById($page_id);
        $page->moveToStart();
        $page->save();

        return redirect()->route('dashboard.pages');
    }

    /**
     * Move down.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveDown($page_id)
    {
        $page = $this->page->getById($page_id);
        $page->moveOrderDown();
        $page->save();

        return redirect()->route('dashboard.pages');
    }

    /**
     * Move last.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveLast($page_id)
    {
        $page = $this->page->getById($page_id);
        $page->moveToEnd();
        $page->save();

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

        $block_dir = array_slice(scandir('chuckbe/'.$template->slug.'/blocks'), 2);
        $blocks = $this->dirToArray($template->path.'/blocks');

        return view('chuckcms::backend.pages.pagebuilder.index', compact('template', 'page', 'pageblocks', 'blocks'));
    }

    public function dirToArray($dir)
    {
        $result = [];

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, ['.', '..'])) {
                if (is_dir($dir.DIRECTORY_SEPARATOR.$value)) {
                    $result[$value] = $this->dirToArray($dir.DIRECTORY_SEPARATOR.$value);
                } else {
                    if ($value !== '.DS_Store' && (strpos($value, '.html') !== false)) {
                        $blockKey = str_replace('.html', '', $value);
                        $blockName = str_replace('-', ' ', $blockKey);
                        if (file_exists($dir.DIRECTORY_SEPARATOR.$blockKey.'.jpg')) {
                            $blockImage = $dir.DIRECTORY_SEPARATOR.$blockKey.'.jpg';
                        } elseif (file_exists($dir.DIRECTORY_SEPARATOR.$blockKey.'.jpeg')) {
                            $blockImage = $dir.DIRECTORY_SEPARATOR.$blockKey.'.jpeg';
                        } elseif (file_exists($dir.DIRECTORY_SEPARATOR.$blockKey.'.png')) {
                            $blockImage = $dir.DIRECTORY_SEPARATOR.$blockKey.'.png';
                        } else {
                            $blockImage = 'https://ui-avatars.com/api/?length=5&size=150&name=BLOCK&background=0D8ABC&color=fff&font-size=0.2';
                        }
                        $result[$blockKey] = [
                            'name'     => $blockName,
                            'location' => $dir.DIRECTORY_SEPARATOR.$value,
                            'img'      => $blockImage,
                        ];
                    }
                }
            }
        }

        return $result;
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
