<?php

namespace Chuckbe\Chuckcms\Requests\UserRoles;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id' => 'required',
        ];
    }
}
