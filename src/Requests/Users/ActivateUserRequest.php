<?php

namespace Chuckbe\Chuckcms\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ActivateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password'       => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            'password_again' => 'required|same:password',
            '_user_token'    => 'required',
            '_user_id'       => 'required',
        ];
    }
}
