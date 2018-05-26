<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Site;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    private $site;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function save(Request $request)
    {
        //validate the request
        $this->validate(request(), [ //@todo create custom Request class for site validation
            'site_name' => 'max:185|required',
            'site_slug' => 'max:70',
            'site_domain' => 'required',
            'socialmedia.*' => 'string|nullable',
            'logo.*' => 'string|nullable',
            'integrations.*' => 'string|nullable',
            'lang' => 'array',
            'site_id' => 'required|nullable'
        ]);

        //create array for settings json
        $settings = [];
        foreach($request->get('socialmedia') as $smKey => $smValue){$settings['socialmedia'][$smKey] = $smValue;}
        foreach($request->get('logo') as $logoKey => $logoValue){$settings['logo'][$logoKey] = $logoValue;}
        foreach($request->get('integrations') as $igsKey => $igsValue){$settings['integrations'][$igsKey] = $igsValue;}
        $settings['lang'] = implode(",",$request->get('lang'));
        
        // updateOrCreate the site
        $site = $this->site->updateOrCreate(
            ['id' => $request->get('site_id')],
            ['name' => $request->get('site_name'),
            'slug' => $request->get('site_slug'),
            'domain' => $request->get('site_domain'),
            'settings' => $settings]
        );

        //redirect back
        return redirect()->route('dashboard.settings')->with('notification', 'Instellingen opgeslagen!');
    }

    public function activateIndex($token)
    {
        // Look up the user
        if (!$user = $this->user->where('token', $token)->where('active', 0)->first()) {
            //if the invite doesn't exist do something more graceful than this
            return redirect()->route('page');
        }

        return view('chuckcms::backend.users._accept', compact('user', 'token'));
    }

    public function activate(Request $request)
    {
        $this->validate(request(), [ //@todo create custom Request class for user password validation
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            'password_again' => 'required|same:password',
            '_user_token' => 'required',
            '_user_id' => 'required'
        ]);

        $token = $request->get('_user_token');
        $user_id = $request->get('_user_id');

        // Look up the user
        if (!$user = $this->user->where('token', $token)->where('id', $user_id)->where('active', 0)->first()) {
            //if the user doesn't exist do something more graceful than this
            return redirect()->route('page');
        }

        $this->user->where('token', $token)->where('id', $user_id)->where('active', 0)->update([
            'active' => 1,
            'password' => bcrypt($request->get('password'))
        ]);

        return redirect()->route('login');
    }
}
