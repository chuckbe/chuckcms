<?php

namespace Chuckbe\Chuckcms\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;

class AddPageMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'labelmenu' => 'required|string|max:185',
            'linkmenu'  => 'required|integer',
            'idmenu'    => 'required|integer',
        ];
    }
}
