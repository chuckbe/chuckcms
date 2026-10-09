<?php

namespace Chuckbe\Chuckcms\Actions\Users;

use Chuckbe\Chuckcms\Mail\UserActivationMail;
use Chuckbe\Chuckcms\Models\User;
use ChuckSite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Build and dispatch a UserActivationMail for the given user. The
 * mail payload previously lived inline in three separate controller
 * methods (invite, save, resendInvitation) verbatim.
 *
 * Note: the from-address is still hardcoded to 'no-reply@chuckcms.com'
 * to preserve exact pre-existing behaviour. Making the sender
 * configurable is tracked as a follow-up.
 */
class SendUserActivationMailAction
{
    public function __invoke(User $user): void
    {
        $mailData = [
            'from'      => 'no-reply@chuckcms.com',
            'from_name' => 'No Reply | ChuckCMS',
            'to'        => $user->email,
            'to_name'   => $user->name,
            'token'     => $user->token,
            'user'      => Auth::user(),
        ];

        Mail::send(new UserActivationMail($mailData, ChuckSite::getSettings()));
    }
}
