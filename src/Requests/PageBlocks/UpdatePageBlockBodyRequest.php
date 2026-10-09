<?php

namespace Chuckbe\Chuckcms\Requests\PageBlocks;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageBlockBodyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pageblock_id' => 'required',
            'html'         => 'required|string',
        ];
    }
}
