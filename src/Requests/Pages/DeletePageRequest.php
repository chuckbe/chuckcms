<?php

namespace Chuckbe\Chuckcms\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;

class DeletePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_id' => 'required',
        ];
    }
}
