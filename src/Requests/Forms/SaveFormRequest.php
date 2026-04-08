<?php

namespace Chuckbe\Chuckcms\Requests\Forms;

use Illuminate\Foundation\Http\FormRequest;

class SaveFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'form_slug'  => 'required|string|max:185',
            'form_title' => 'required|string|max:185',
        ];
    }
}
