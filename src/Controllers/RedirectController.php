<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Redirect;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RedirectController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Redirect $redirect)
    {
        $this->redirect = $redirect;
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

    public function create(Request $request)
    {
        //$request['slug'] = str_slug($request->slug, '-');

        $this->validate($request, [//@todo create custom Request class for redirect validation
            'slug' => 'max:185|required|unique:redirects',
            'to' => 'required|max:185',
            'type' => 'required|numeric|in:301,302'
        ]);

        $redirect = Redirect::firstOrNew(
            ['slug' => $request['slug']], 
            ['to' => $request['to'], 
            'type' => $request['type']]);

        if ($redirect->save()) {
            return redirect()->route('dashboard.redirects');
        }
    }

    public function update(Request $request)
    {
        //$request['slug'] = str_slug($request->slug, '-');

        $this->validate($request, [//@todo create custom Request class for redirect validation
            'id' => 'required',
            'slug' => 'required|max:185',
            'to' => 'required|max:185',
            'type' => 'required|numeric|in:301,302'
        ]);

        $redirect = Redirect::where('id', $request['id'])->update([
            'slug' => $request['slug'], 
            'to' => $request['to'], 
            'type' => $request['type']
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
