<?php

namespace Chuckbe\Chuckcms\Requests\Redirects;

use Illuminate\Foundation\Http\FormRequest;

class CreateRedirectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'max:185|required|unique:redirects',
            'to'   => 'required|max:185',
            'type' => 'required|numeric|in:301,302',
        ];
    }
}
