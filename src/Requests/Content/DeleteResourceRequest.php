<?php

namespace Chuckbe\Chuckcms\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class DeleteResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resource_id' => 'required',
        ];
    }
}
