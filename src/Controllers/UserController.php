<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Mail\UserActivationMail;
use Chuckbe\Chuckcms\Models\User;
use ChuckSite;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $user;
    private $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, UserRepository $userRepository)
    {
        $this->user = $user;
        $this->userRepository = $userRepository;
    }

    /**
     * Show the dashboard -> users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->get();
        
        return view('chuckcms::backend.users.index', compact('users'));
    }

    public function invite(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'name' => 'max:185|required',
            'email' => 'email|required|unique:users',
            'role' => 'required|in:user,moderator,administrator,super-admin'
        ]);

        // create the user
        $user = $this->user->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'token' => $this->userRepository->createToken(),
            'password' => bcrypt($this->userRepository->createToken())
        ]);
        // add role
        $user->assignRole($request->get('role'));

        //send the email
        $mailData = [];
        $mailData['from'] = 'no-reply@chuckcms.com';
        $mailData['from_name'] = 'No Reply | ChuckCMS';
        $mailData['to'] = $user->email;
        $mailData['to_name'] = $user->name;
        $mailData['token'] = $user->token;
        $mailData['user'] = \Auth::user();

        $settings = ChuckSite::getSettings();

        //dd($mailData);

        Mail::send(new UserActivationMail($mailData, $settings));

        //redirect back
        return redirect()->back()->with('notification', 'Gebruiker uitgenodigd!');
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
        $this->validate(request(), [//@todo create custom Request class for user password validation
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

    /**
     * Show the edit user page.
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('chuckcms::backend.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'name' => 'max:185|required',
            'email' => 'email|required',
            'role' => 'required|in:user,moderator,administrator,super-admin'
        ]);

        // update the user
        $user = $this->user->create([// TODO CHANGE TO UPDATE METHOD
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'token' => $this->userRepository->createToken(),
            'password' => bcrypt($this->userRepository->createToken())
        ]);
        // add role
        $user->assignRole($request->get('role'));

        //send the email
        $mailData = [];
        $mailData['from'] = 'no-reply@chuckcms.com';
        $mailData['from_name'] = 'No Reply | ChuckCMS';
        $mailData['to'] = $user->email;
        $mailData['to_name'] = $user->name;
        $mailData['token'] = $user->token;
        $mailData['user'] = \Auth::user();

        $settings = ChuckSite::getSettings();

        //dd($mailData);

        Mail::send(new UserActivationMail($mailData, $settings));

        //redirect back
        return redirect()->back()->with('notification', 'Gebruiker uitgenodigd!');
    }
}
