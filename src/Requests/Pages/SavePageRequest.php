<?php

namespace Chuckbe\Chuckcms\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;

class SavePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_title' => 'max:185',
        ];
    }
}
