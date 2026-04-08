<?php

namespace Chuckbe\Chuckcms\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;

class GenerateMenuControlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'idmenu'             => 'required|integer',
            'menuname'           => 'required|string|max:185',
            'arraydata'          => 'nullable|array',
            'arraydata.*.id'     => 'required_with:arraydata|integer',
            'arraydata.*.parent' => 'present',
            'arraydata.*.sort'   => 'required_with:arraydata|integer',
            'arraydata.*.depth'  => 'required_with:arraydata|integer',
        ];
    }
}
