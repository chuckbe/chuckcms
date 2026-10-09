<?php

namespace Chuckbe\Chuckcms\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class SaveResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug'             => 'required',
            'resource_key.*'   => 'required',
            'resource_value.*' => 'required',
        ];
    }
}
