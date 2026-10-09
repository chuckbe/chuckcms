<?php

namespace Chuckbe\Chuckcms\Actions\Forms;

use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Requests\Forms\SaveFormRequest;

class SaveFormAction
{
    /**
     * Persist the form-builder payload. This action is the destination
     * for the form-builder POST and is the main offender the original
     * codebase had in terms of deeply nested loops: the old controller
     * method was 60 lines of array key assembly.
     */
    public function __invoke(SaveFormRequest $request): Form
    {
        $form = [
            'fields'  => $this->buildFields($request),
            'actions' => [
                'store'    => $this->toBool($request->input('action_store')),
                'send'     => $this->buildSendActions($request),
                'redirect' => $request->input('action_redirect'),
            ],
            'files' => $this->toBool($request->input('files_allowed')),
            'button' => [
                'class' => $request->input('button_class'),
                'label' => $request->input('button_label'),
                'id'    => $request->input('button_id'),
            ],
        ];

        return Form::updateOrCreate(
            ['id' => $request->input('form_id')],
            [
                'title' => $request->input('form_title'),
                'slug'  => $request->input('form_slug'),
                'form'  => $form,
            ],
        );
    }

    private function buildFields(SaveFormRequest $request): array
    {
        $formSlug = $request->input('form_slug');
        $fieldsSlug = (array) $request->input('fields_slug', []);

        $fields = [];
        foreach ($fieldsSlug as $i => $slug) {
            $key = $formSlug.'_'.$slug;
            $fields[$key] = [
                'label'       => $request->input('fields_label')[$i] ?? null,
                'type'        => $request->input('fields_type')[$i] ?? null,
                'class'       => $request->input('fields_class')[$i] ?? null,
                'parentclass' => $request->input('fields_parentclass')[$i] ?? null,
                'placeholder' => $request->input('fields_placeholder')[$i] ?? null,
                'validation'  => $request->input('fields_validation')[$i] ?? null,
                'value'       => $request->input('fields_value')[$i] ?? null,
                'attributes'  => $this->parseAttributes(
                    $request->input('fields_attributes_name')[$i] ?? '',
                    $request->input('fields_attributes_value')[$i] ?? '',
                ),
                'required' => $request->input('fields_required')[$i] ?? null,
            ];
        }

        return $fields;
    }

    /**
     * fields_attributes_name/value are semicolon-separated strings
     * holding arbitrary HTML attribute key/value pairs.
     */
    private function parseAttributes(string $names, string $values): array
    {
        $nameParts = explode(';', $names);
        $valueParts = explode(';', $values);
        $attributes = [];
        $count = count($nameParts);
        for ($k = 0; $k < $count; $k++) {
            $attributes[$nameParts[$k]] = $valueParts[$k] ?? null;
        }

        return $attributes;
    }

    /**
     * Return either false (no send action configured) or a nested
     * array keyed by action slug.
     */
    private function buildSendActions(SaveFormRequest $request): array|false
    {
        $action = $request->input('action_send');
        if ($action === 'false' || $action === false) {
            return false;
        }

        $slugs = (array) $request->input('action_send_slug', []);
        $send = [];
        foreach ($slugs as $g => $slug) {
            $send[$slug] = [
                'to'        => $request->input('action_send_to')[$g] ?? null,
                'to_name'   => $request->input('action_send_to_name')[$g] ?? null,
                'from'      => $request->input('action_send_from')[$g] ?? null,
                'from_name' => $request->input('action_send_from_name')[$g] ?? null,
                'subject'   => $request->input('action_send_subject')[$g] ?? null,
                'body'      => $request->input('action_send_body')[$g] ?? null,
                'files'     => $request->input('action_send_files')[$g] ?? null,
                'template'  => $request->input('action_send_template')[$g] ?? null,
            ];
        }

        return $send;
    }

    private function toBool(mixed $value): bool
    {
        return $value === 'true' || $value === true;
    }
}
