<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Redirects\CreateRedirectAction;
use Chuckbe\Chuckcms\Actions\Redirects\DeleteRedirectAction;
use Chuckbe\Chuckcms\Actions\Redirects\UpdateRedirectAction;
use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Requests\Redirects\CreateRedirectRequest;
use Chuckbe\Chuckcms\Requests\Redirects\DeleteRedirectRequest;
use Chuckbe\Chuckcms\Requests\Redirects\UpdateRedirectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class RedirectController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct(private Redirect $redirect)
    {
    }

    /**
     * Show the dashboard -> menus index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = $this->redirect->get();

        return view('chuckcms::backend.redirects.index', compact('redirects'));
    }

    public function create(CreateRedirectRequest $request, CreateRedirectAction $createRedirect)
    {
        $createRedirect($request);

        return redirect()->route('dashboard.redirects');
    }

    public function update(UpdateRedirectRequest $request, UpdateRedirectAction $updateRedirect)
    {
        $updateRedirect($request);

        return redirect()->route('dashboard.redirects');
    }

    public function delete(DeleteRedirectRequest $request, DeleteRedirectAction $deleteRedirect)
    {
        $deleteRedirect($request);

        return redirect()->route('dashboard.redirects');
    }
}
