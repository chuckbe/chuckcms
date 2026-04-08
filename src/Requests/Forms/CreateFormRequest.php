<?php

namespace Chuckbe\Chuckcms\Requests\Forms;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug'  => 'max:185|required|unique:forms',
            'title' => 'required|max:185',
        ];
    }
}
