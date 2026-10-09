<?php

namespace Chuckbe\Chuckcms\Actions\UserRoles;

use Chuckbe\Chuckcms\Requests\UserRoles\DeleteRoleRequest;
use Spatie\Permission\Models\Role;

class DeleteRoleAction
{
    public function __invoke(DeleteRoleRequest $request): bool
    {
        $role = Role::findById($request->input('role_id'));

        return (bool) $role->delete();
    }
}
