<?php

namespace Chuckbe\Chuckcms\Requests\Forms;

use Chuckbe\Chuckcms\Models\Form;
use Illuminate\Foundation\Http\FormRequest;

class SubmitFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dynamic rules — loaded from the form's stored field validation
     * config. Includes the honeypot-package rules that were previously
     * injected inline.
     */
    public function rules(): array
    {
        $form = Form::where('slug', $this->input('_form_slug'))->first();
        if ($form === null) {
            return ['_form_slug' => 'required'];
        }

        $rules = [];
        foreach ($form->form['fields'] as $fieldKey => $fieldValue) {
            $rules[$fieldKey] = $fieldValue['validation'];
        }
        $rules['chuck_telephone'] = 'honeypot';
        $rules['chuck_email'] = 'required|honeytime:12';

        return $rules;
    }
}
