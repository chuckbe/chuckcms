<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Redirect;
use Chuckbe\Chuckcms\Requests\Redirects\CreateRedirectRequest;
use Chuckbe\Chuckcms\Requests\Redirects\UpdateRedirectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
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

    public function create(CreateRedirectRequest $request)
    {
        //$request['slug'] = str_slug($request->slug, '-');

        $redirect = Redirect::firstOrNew(
            ['slug' => $request['slug']],
            ['to'      => $request['to'],
                'type' => $request['type'], ]
        );

        if ($redirect->save()) {
            return redirect()->route('dashboard.redirects');
        }
    }

    public function update(UpdateRedirectRequest $request)
    {
        //$request['slug'] = str_slug($request->slug, '-');

        $redirect = Redirect::where('id', $request['id'])->update([
            'slug' => $request['slug'],
            'to'   => $request['to'],
            'type' => $request['type'],
        ]);

        return redirect()->route('dashboard.redirects');
    }

    public function delete(Request $request)
    {
        $this->validate($request, ['id' => 'required']);

        $redirect = Redirect::where('id', $request['id'])->first();

        if ($redirect->delete()) {
            return redirect()->route('dashboard.redirects');
        }
    }
}
