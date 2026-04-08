<?php

namespace Chuckbe\Chuckcms\Actions\UserRoles;

use Chuckbe\Chuckcms\Requests\UserRoles\CreateRoleRequest;
use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    public function __invoke(CreateRoleRequest $request): Role
    {
        return Role::firstOrCreate(
            ['name' => $request->input('role_name')],
            ['redirect' => $request->input('role_redirect')],
        );
    }
}
