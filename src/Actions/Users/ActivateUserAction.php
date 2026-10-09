<?php

namespace Chuckbe\Chuckcms\Actions\Users;

use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\Users\ActivateUserRequest;

class ActivateUserAction
{
    /**
     * Activate a user by matching token + user_id + active=0 and
     * setting their chosen password. Returns true on success, false
     * if the tuple did not match a pending user.
     */
    public function __invoke(ActivateUserRequest $request): bool
    {
        $token = $request->input('_user_token');
        $userId = $request->input('_user_id');

        $user = User::where('token', $token)
            ->where('id', $userId)
            ->where('active', 0)
            ->first();

        if ($user === null) {
            return false;
        }

        User::where('token', $token)
            ->where('id', $userId)
            ->where('active', 0)
            ->update([
                'active'   => 1,
                'password' => bcrypt($request->input('password')),
            ]);

        return true;
    }
}
