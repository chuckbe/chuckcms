<?php

namespace Chuckbe\Chuckcms\Controllers\Auth;


use Chuckbe\Chuckcms\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SendsPasswordResetEmails;

    // public function showLinkRequestForm(Request $request)
    // {
    //     if ($request->token == null) {
    //         $template = Template::first();
    //         return view('chuckcms::auth.passwords.email', compact('template'));
    //     } else {
    //         $template = Template::first();
    //         return view('chuckcms::auth.passwords.reset')->with(
    //             ['template' => $template, 'token' => $request->token, 'email' => $request->email]
    //         );
    //     }
        
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
