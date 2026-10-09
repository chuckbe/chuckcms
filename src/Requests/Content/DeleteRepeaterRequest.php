<?php

namespace Chuckbe\Chuckcms\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRepeaterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content_id' => 'required',
        ];
    }
}
