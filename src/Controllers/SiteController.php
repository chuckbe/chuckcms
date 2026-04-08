<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Sites\SaveSiteSettingsAction;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\Sites\SaveSiteRequest;
use Chuckbe\Chuckcms\Requests\Users\ActivateUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SiteController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct(private User $user)
    {
    }

    public function save(SaveSiteRequest $request, SaveSiteSettingsAction $saveSiteSettings)
    {
        $saveSiteSettings($request);

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

    public function activate(ActivateUserRequest $request)
    {
        $token = $request->get('_user_token');
        $user_id = $request->get('_user_id');

        // Look up the user
        if (!$user = $this->user->where('token', $token)->where('id', $user_id)->where('active', 0)->first()) {
            //if the user doesn't exist do something more graceful than this
            return redirect()->route('page');
        }

        $this->user->where('token', $token)->where('id', $user_id)->where('active', 0)->update([
            'active'   => 1,
            'password' => bcrypt($request->get('password')),
        ]);

        return redirect()->route('login');
    }
}
