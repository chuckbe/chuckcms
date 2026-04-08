<?php

namespace Chuckbe\Chuckcms\Actions\Users;

use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\Users\DeleteUserRequest;

class DeleteUserAction
{
    /**
     * Delete a user after first revoking any roles/permissions they
     * held directly. Preserves the legacy tri-state string return
     * contract the frontend JS depends on:
     *   'success' / 'error' / 'false'
     */
    public function __invoke(DeleteUserRequest $request): string
    {
        $user = User::find($request->input('user_id'));
        if ($user === null) {
            return 'false';
        }

        foreach ($user->getRoleNames() as $role) {
            $user->removeRole($role);
        }
        foreach ($user->getDirectPermissions() as $permission) {
            $user->removePermissionTo($permission);
        }

        return $user->delete() ? 'success' : 'error';
    }
}
