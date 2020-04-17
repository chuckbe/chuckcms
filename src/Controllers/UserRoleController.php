<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Models\User;
use ChuckSite;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserRoleController extends BaseController
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
     * Show the dashboard -> roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::all();
        
        return view('chuckcms::backend.users.roles.index', compact('roles'));
    }

    public function create(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'role_name' => 'max:185|required',
            'role_redirect' => 'max:255|required'
        ]);

        $role = Role::firstOrCreate(['name' => $request->role_name],['redirect' => $request->role_redirect]);

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

    public function save(Request $request)
    {
        $this->validate(request(), [//@todo create custom Request class for page validation
            'role_name' => 'max:185|required',
            'role_redirect' => 'max:255|required',
            'role_id' => 'required',
            'permissions_name.*' => 'required',
            'permissions_active.*' => 'required'
        ]);

        $role = Role::findById($request->role_id);
        $role->name = $request->role_name;
        $role->redirect = $request->role_redirect;
        $role->save();

        $permissions = [];
        $countPermissions = count($request->permissions_name);
        for ($i=0; $i < $countPermissions; $i++) { 
            if($request->permissions_active[$i] == 1) {
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
        if ( $role->delete() ) {
            return redirect()->route('dashboard.users.roles')->with('notification', 'Rol verwijderd!');
        } else {
            return redirect()->route('dashboard.users.roles')->with('whoops', 'Er is iets misgegaan, probeer het later nog eens!');
        }
    }
}
