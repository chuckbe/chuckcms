<?php

namespace Chuckbe\Chuckcms\Requests\Forms;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'form_id' => 'required',
        ];
    }
}
