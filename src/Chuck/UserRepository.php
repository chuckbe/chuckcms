<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\User;
use Str;

class UserRepository
{
    protected $user; 

	public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createToken()
    {
        // generate a random string using Laravel's str_random helper
        // check if the token already exists and if it does, try again
        do {
            $token = Str::random(24);
        } while ($this->user->where('token', $token)->first());

        return $token;
    }
}
