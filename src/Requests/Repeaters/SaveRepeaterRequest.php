<?php

namespace Chuckbe\Chuckcms\Requests\Repeaters;

use Illuminate\Foundation\Http\FormRequest;

class SaveRepeaterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content_slug' => 'required|string|max:185',
            'content_type' => 'required|string|max:185',
            'fields_slug'  => 'nullable|array',
        ];
    }
}
