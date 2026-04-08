<?php

namespace Chuckbe\Chuckcms\Requests\Templates;

use Illuminate\Foundation\Http\FormRequest;

class SaveTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_id' => 'required',
        ];
    }
}
