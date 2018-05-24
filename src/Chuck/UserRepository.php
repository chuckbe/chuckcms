<?php

namespace Chuckbe\Chuckcms\Chuck;

use Chuckbe\Chuckcms\Models\User;

use App\Http\Requests;

class UserRepository
{
	public function __construct(User $user)
    {
        $this->user = $user;
    }

}