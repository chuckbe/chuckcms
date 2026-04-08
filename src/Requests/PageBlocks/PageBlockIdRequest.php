<?php

namespace Chuckbe\Chuckcms\Requests\PageBlocks;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Shared FormRequest for the several pageblock endpoints that only
 * need a pageblock_id. Used by show, moveUp, moveDown, delete.
 */
class PageBlockIdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pageblock_id' => 'required',
        ];
    }
}
