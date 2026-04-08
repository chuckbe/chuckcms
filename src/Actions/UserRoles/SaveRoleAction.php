<?php

namespace Chuckbe\Chuckcms\Actions\UserRoles;

use Chuckbe\Chuckcms\Requests\UserRoles\SaveRoleRequest;
use Spatie\Permission\Models\Role;

class SaveRoleAction
{
    public function __invoke(SaveRoleRequest $request): Role
    {
        $role = Role::findById($request->input('role_id'));
        $role->name = $request->input('role_name');
        $role->redirect = $request->input('role_redirect');
        $role->save();

        $this->syncPermissions($role, $request->input('permissions_name', []), $request->input('permissions_active', []));

        return $role;
    }

    /**
     * Apply the permission-toggle payload to the role: indexes where
     * permissions_active[$i] === 1 get granted, everything else gets
     * revoked. Matches the exact semantics of the original inline loop
     * on the controller.
     */
    private function syncPermissions(Role $role, array $names, array $active): void
    {
        $count = count($names);
        for ($i = 0; $i < $count; $i++) {
            if (($active[$i] ?? null) == 1) {
                $role->givePermissionTo($names[$i]);
            } else {
                $role->revokePermissionTo($names[$i]);
            }
        }
    }
}
