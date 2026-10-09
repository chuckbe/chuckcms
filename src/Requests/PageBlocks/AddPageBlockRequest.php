<?php

namespace Chuckbe\Chuckcms\Requests\PageBlocks;

use Illuminate\Foundation\Http\FormRequest;

class AddPageBlockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location' => 'required|string',
            'page_id'  => 'required',
            'name'     => 'required|string',
        ];
    }
}
