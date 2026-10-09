<?php

namespace Chuckbe\Chuckcms\Actions\Repeaters;

use Chuckbe\Chuckcms\Models\Content;
use Chuckbe\Chuckcms\Requests\Repeaters\SaveRepeaterRequest;

class SaveRepeaterAction
{
    public function __invoke(SaveRepeaterRequest $request): Content
    {
        $contentSlug = $request->input('content_slug');

        $content = [
            'fields'  => $this->buildFields($request, $contentSlug),
            'actions' => $this->buildActions($request),
            'files'   => $request->input('files_allowed'),
        ];

        return Content::updateOrCreate(
            ['id' => $request->input('content_id')],
            [
                'slug'    => $contentSlug,
                'type'    => $request->input('content_type'),
                'content' => $content,
            ],
        );
    }

    private function buildFields(SaveRepeaterRequest $request, string $contentSlug): array
    {
        $fieldsSlug = (array) $request->input('fields_slug', []);

        $fields = [];
        foreach ($fieldsSlug as $i => $slug) {
            $key = $contentSlug.'_'.$slug;
            $fields[$key] = [
                'label'       => $request->input('fields_label')[$i] ?? null,
                'type'        => $request->input('fields_type')[$i] ?? null,
                'class'       => $request->input('fields_class')[$i] ?? null,
                'placeholder' => $request->input('fields_placeholder')[$i] ?? null,
                'validation'  => $request->input('fields_validation')[$i] ?? null,
                'value'       => $request->input('fields_value')[$i] ?? null,
                'attributes'  => $this->parseAttributes(
                    $request->input('fields_attributes_name')[$i] ?? '',
                    $request->input('fields_attributes_value')[$i] ?? '',
                ),
                'required' => $request->input('fields_required')[$i] ?? null,
                'table'    => $request->input('fields_table')[$i] ?? null,
            ];
        }

        return $fields;
    }

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

    private function buildActions(SaveRepeaterRequest $request): array
    {
        $actions = ['store' => $request->input('action_store')];

        if ($request->input('action_detail') === 'true') {
            $actions['detail'] = [
                'url'  => $request->input('action_detail_url'),
                'page' => $request->input('action_detail_page'),
            ];
        } else {
            $actions['detail'] = 'false';
        }

        return $actions;
    }
}
