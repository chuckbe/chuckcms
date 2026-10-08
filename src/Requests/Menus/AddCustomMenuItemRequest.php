<?php

namespace Chuckbe\Chuckcms\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;

class AddCustomMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'labelmenu' => 'required|string|max:255',
            'linkmenu'  => 'required|string|max:255',
            'idmenu'    => 'required|integer',
        ];
    }
}
