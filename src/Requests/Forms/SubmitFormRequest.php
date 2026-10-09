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
     * config. Spam is handled by the ProtectAgainstSpam middleware on the
     * route, before this request is validated.
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

        return $rules;
    }
}
