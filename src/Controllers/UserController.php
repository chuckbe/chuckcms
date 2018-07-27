<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Mail\UserActivationMail;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Models\User;
use ChuckSite;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class UserController extends Controller
{
    private $user;
    private $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, UserRepository $userRepository, Template $template)
    {
        $this->user = $user;
        $this->userRepository = $userRepository;
        $this->template = $template;
    }

    /**
     * Show the dashboard -> users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = $this->template->where('active', 1)->where('type', 'admin')->first();
        $front_template = $this->template->where('active', 1)->where('type', 'default')->where('slug', $template->slug)->first();
        $users = $this->user->get();
        
        return view('chuckcms::backend.users.index', compact('template', 'front_template', 'users'));
    }

    public function invite(Request $request)
    {
        $this->validate(request(), [ //@todo create custom Request class for page validation
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
