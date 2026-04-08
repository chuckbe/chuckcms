<?php

namespace Chuckbe\Chuckcms\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class ImportRepeaterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'required',
            'file' => 'required|file|mimetypes:application/json,application/octet-stream,text/plain',
        ];
    }
}
