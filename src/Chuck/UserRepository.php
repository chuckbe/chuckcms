<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\User;

class UserRepository
{
    protected $user; 

	public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createToken()
    {
        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random(24);
        } //check if the token already exists and if it does, try again
        while ($this->user->where('token', $token)->first());
        return $token;
    }

}