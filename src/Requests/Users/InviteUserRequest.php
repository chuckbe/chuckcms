<?php

namespace Chuckbe\Chuckcms\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class InviteUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'max:185|required',
            'email' => 'email|required|unique:users',
            'role'  => 'required|in:user,moderator,administrator,super-admin',
        ];
    }
}
