<?php

namespace Chuckbe\Chuckcms\Actions\Users;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\Users\SaveUserRequest;

/**
 * Handles the /dashboard/user/save endpoint.
 *
 * IMPORTANT — pre-existing bug preserved: the original
 * UserController::save() called User::create() rather than updating
 * an existing user, with a '// TODO CHANGE TO UPDATE METHOD' comment
 * left by the original author. Calling save on an existing user thus
 * attempts to create a second row with the same email and fails on
 * the unique constraint. This action preserves that exact behaviour
 * because fixing it is a scoped follow-up tracked separately; any
 * change here would be functional (not a refactor) and requires a
 * decision on what "save" should actually do.
 */
class SaveUserAction
{
    public function __construct(
        private UserRepository $userRepository,
        private SendUserActivationMailAction $sendActivationMail,
    ) {
    }

    public function __invoke(SaveUserRequest $request): User
    {
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'token'    => $this->userRepository->createToken(),
            'password' => bcrypt($this->userRepository->createToken()),
        ]);
        $user->assignRole($request->input('role'));

        ($this->sendActivationMail)($user);

        return $user;
    }
}
