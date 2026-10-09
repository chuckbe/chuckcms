<?php

namespace Chuckbe\Chuckcms\Requests\Redirects;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRedirectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }
}
