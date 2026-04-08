<?php

namespace Chuckbe\Chuckcms\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The endpoint accepts two payload shapes: a batch 'arraydata'
     * variant used by the drag-and-drop builder, or a single-item
     * update with id/label/url/clases keys. Validation stays lenient
     * to accommodate both; the action normalises the payload.
     */
    public function rules(): array
    {
        return [
            'arraydata' => 'nullable|array',
            'id'        => 'nullable|integer',
            'label'     => 'nullable|string|max:185',
            'url'       => 'nullable|string|max:2048',
            'clases'    => 'nullable|string|max:185',
        ];
    }
}
