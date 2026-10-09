<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Users\ActivateUserAction;
use Chuckbe\Chuckcms\Actions\Users\DeleteUserAction;
use Chuckbe\Chuckcms\Actions\Users\InviteUserAction;
use Chuckbe\Chuckcms\Actions\Users\ResendInvitationAction;
use Chuckbe\Chuckcms\Actions\Users\SaveUserAction;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\Users\ActivateUserRequest;
use Chuckbe\Chuckcms\Requests\Users\DeleteUserRequest;
use Chuckbe\Chuckcms\Requests\Users\InviteUserRequest;
use Chuckbe\Chuckcms\Requests\Users\ResendInvitationRequest;
use Chuckbe\Chuckcms\Requests\Users\SaveUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct(private User $user)
    {
    }

    /**
     * Show the dashboard -> users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->get();
        $roles = Role::all();

        return view('chuckcms::backend.users.index', compact('users', 'roles'));
    }

    public function invite(InviteUserRequest $request, InviteUserAction $inviteUser)
    {
        $inviteUser($request);

        return redirect()->back()->with('notification', 'Gebruiker uitgenodigd!');
    }

    public function activateIndex($token)
    {
        $user = $this->user->where('token', $token)->where('active', 0)->first();

        if (!$user) {
            return redirect()->route('page');
        }

        return view('chuckcms::backend.users._accept', compact('user', 'token'));
    }

    public function activate(ActivateUserRequest $request, ActivateUserAction $activateUser)
    {
        if (!$activateUser($request)) {
            return redirect()->route('page');
        }

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

    public function resendInvitation(ResendInvitationRequest $request, ResendInvitationAction $resendInvitation): string
    {
        $resendInvitation($request);

        return 'success';
    }

    public function save(SaveUserRequest $request, SaveUserAction $saveUser)
    {
        $saveUser($request);

        return redirect()->back()->with('notification', 'Gebruiker uitgenodigd!');
    }

    public function delete(DeleteUserRequest $request, DeleteUserAction $deleteUser): string
    {
        return $deleteUser($request);
    }
}
