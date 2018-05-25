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

    public function invite(Request $request)
    {
        $this->validate(request(), [ //@todo create custom Request class for page validation
            'name' => 'max:185|required',
            'email' => 'email|required|unique:users',
            'role' => 'required|in:user,moderator,administrator,super-admin'
        ]);

        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random(24);
        } //check if the token already exists and if it does, try again
        while ($this->user->where('token', $token)->first());
        // create the user
        $user = $this->user->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'token' => $token,
            'password' => bcrypt($token)
        ]);
        // add role
        $user->assignRole($request->get('role'));

        //send the email
        //@todo send notification with token url

        //redirect back
        return redirect()->back()->with('notification', 'Gebruiker uitgenodigd!');
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
