<?php

namespace Chuckbe\Chuckcms\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }
}
