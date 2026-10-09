<?php

namespace Chuckbe\Chuckcms\Actions\Forms;

use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Requests\Forms\CreateFormRequest;
use ChuckSite;

class CreateFormAction
{
    /**
     * Scaffold a brand-new form with a single text field, a default
     * "store" action, and the current site's domain as the redirect
     * target. Matches the exact shape the old FormController::create()
     * was building inline.
     */
    public function __invoke(CreateFormRequest $request): Form
    {
        $slug = $request->input('slug');
        $fieldKey = $slug.'_text';

        $form = [
            'fields' => [
                $fieldKey => [
                    'label'       => 'Text',
                    'type'        => 'text',
                    'class'       => 'form-control',
                    'parentclass' => null,
                    'placeholder' => 'Text',
                    'validation'  => 'required',
                    'value'       => null,
                    'attributes'  => ['id' => 'text_input_id'],
                    'required'    => 'true',
                ],
            ],
            'actions' => [
                'store'    => true,
                'send'     => false,
                'redirect' => ChuckSite::getSite('domain'),
            ],
            'files'  => false,
            'button' => [
                'class' => 'btn btn-primary',
                'label' => 'Send',
                'id'    => 'send_form_btn',
            ],
        ];

        return Form::create([
            'title' => $request->input('title'),
            'slug'  => $slug,
            'form'  => $form,
        ]);
    }
}
