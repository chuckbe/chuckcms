<?php

namespace Chuckbe\Chuckcms\Requests\Sites;

use Illuminate\Foundation\Http\FormRequest;

class SaveSiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_name'      => 'max:185|required',
            'site_slug'      => 'max:70',
            'site_domain'    => 'required',
            'company.*'      => 'string|nullable',
            'socialmedia.*'  => 'string|nullable',
            'favicon.*'      => 'string|nullable',
            'logo.*'         => 'string|nullable',
            'integrations.*' => 'string|nullable',
            'lang'           => 'array',
            'site_id'        => 'required|nullable',
        ];
    }
}
