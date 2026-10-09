<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\UserRoles\CreateRoleRequest;
use Chuckbe\Chuckcms\Requests\UserRoles\SaveRoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        private User $user,
        private UserRepository $userRepository,
    ) {
    }

    /**
     * Show the dashboard -> roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::all();

        return view('chuckcms::backend.users.roles.index', compact('roles'));
    }

    public function create(CreateRoleRequest $request)
    {
        $role = Role::firstOrCreate(['name' => $request->role_name], ['redirect' => $request->role_redirect]);

        return redirect()->route('dashboard.users.roles.edit', ['role' => $role->id])->with('notification', 'Rol aangemaakt!');
    }

    /**
     * Show the edit user page.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('chuckcms::backend.users.roles.edit', compact('role', 'permissions'));
    }

    public function save(SaveRoleRequest $request)
    {
        $role = Role::findById($request->role_id);
        $role->name = $request->role_name;
        $role->redirect = $request->role_redirect;
        $role->save();

        $permissions = [];
        $countPermissions = count($request->permissions_name);
        for ($i = 0; $i < $countPermissions; $i++) {
            if ($request->permissions_active[$i] == 1) {
                $role->givePermissionTo($request->permissions_name[$i]);
            } else {
                $role->revokePermissionTo($request->permissions_name[$i]);
            }
        }

        //redirect back
        return redirect()->route('dashboard.users.roles')->with('notification', 'Rol gewijzigd!');
    }

    /**
     * Delete the role.
     *
     * @return string $status
     */
    public function delete(Request $request)
    {
        $this->validate(request(), [
            'role_id' => 'required',
        ]);

        $role = Role::findById($request->get('role_id'));
        if ($role->delete()) {
            return redirect()->route('dashboard.users.roles')->with('notification', 'Rol verwijderd!');
        } else {
            return redirect()->route('dashboard.users.roles')->with('whoops', 'Er is iets misgegaan, probeer het later nog eens!');
        }
    }
}
