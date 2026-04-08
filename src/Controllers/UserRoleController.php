<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\UserRoles\CreateRoleAction;
use Chuckbe\Chuckcms\Actions\UserRoles\DeleteRoleAction;
use Chuckbe\Chuckcms\Actions\UserRoles\SaveRoleAction;
use Chuckbe\Chuckcms\Requests\UserRoles\CreateRoleRequest;
use Chuckbe\Chuckcms\Requests\UserRoles\DeleteRoleRequest;
use Chuckbe\Chuckcms\Requests\UserRoles\SaveRoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

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

    public function create(CreateRoleRequest $request, CreateRoleAction $createRole)
    {
        $role = $createRole($request);

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

    public function save(SaveRoleRequest $request, SaveRoleAction $saveRole)
    {
        $saveRole($request);

        return redirect()->route('dashboard.users.roles')->with('notification', 'Rol gewijzigd!');
    }

    public function delete(DeleteRoleRequest $request, DeleteRoleAction $deleteRole)
    {
        if ($deleteRole($request)) {
            return redirect()->route('dashboard.users.roles')->with('notification', 'Rol verwijderd!');
        }

        return redirect()->route('dashboard.users.roles')->with('whoops', 'Er is iets misgegaan, probeer het later nog eens!');
    }
}
