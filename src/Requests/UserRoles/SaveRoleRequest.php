<?php

namespace Chuckbe\Chuckcms\Requests\UserRoles;

use Illuminate\Foundation\Http\FormRequest;

class SaveRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_name'            => 'max:185|required',
            'role_redirect'        => 'max:255|required',
            'role_id'              => 'required',
            'permissions_name.*'   => 'required',
            'permissions_active.*' => 'required',
        ];
    }
}
