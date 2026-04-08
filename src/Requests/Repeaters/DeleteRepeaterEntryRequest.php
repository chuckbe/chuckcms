<?php

namespace Chuckbe\Chuckcms\Requests\Repeaters;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRepeaterEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'repeater_id' => 'required',
        ];
    }
}
