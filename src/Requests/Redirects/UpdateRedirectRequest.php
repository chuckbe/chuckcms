<?php

namespace Chuckbe\Chuckcms\Requests\Redirects;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRedirectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'   => 'required',
            'slug' => 'required|max:185',
            'to'   => 'required|max:185',
            'type' => 'required|numeric|in:301,302',
        ];
    }
}
