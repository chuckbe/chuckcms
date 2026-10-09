<?php

namespace Chuckbe\Chuckcms\Actions\Users;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\Users\InviteUserRequest;

class InviteUserAction
{
    public function __construct(
        private UserRepository $userRepository,
        private SendUserActivationMailAction $sendActivationMail,
    ) {
    }

    public function __invoke(InviteUserRequest $request): User
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
