<?php

namespace Chuckbe\Chuckcms\Actions\Users;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Models\User;
use Chuckbe\Chuckcms\Requests\Users\ResendInvitationRequest;

class ResendInvitationAction
{
    public function __construct(
        private UserRepository $userRepository,
        private SendUserActivationMailAction $sendActivationMail,
    ) {
    }

    public function __invoke(ResendInvitationRequest $request): User
    {
        $user = User::findOrFail($request->input('user_id'));

        $user->update([
            'active' => 0,
            'token'  => $this->userRepository->createToken(),
        ]);

        ($this->sendActivationMail)($user);

        return $user;
    }
}
