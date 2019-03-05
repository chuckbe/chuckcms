<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Chuck\SiteRepository;
use Chuckbe\Chuckcms\Models\User;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SiteController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $site;
    private $siteRepository;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Site $site, SiteRepository $siteRepository, User $user)
    {
        $this->site = $site;
        $this->siteRepository = $siteRepository;
        $this->user = $user;
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

        //update or create settings
        $this->siteRepository->updateOrCreateFromRequest($request);

        //redirect back
        return redirect()->route('dashboard.settings')->with('notification', 'Instellingen opgeslagen!');
    }

    public function activateIndex($token)
    {
        // Look up the user
        $user = $this->user->where('token', $token)->where('active', 0)->first();
        
        if (!$user) {
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
