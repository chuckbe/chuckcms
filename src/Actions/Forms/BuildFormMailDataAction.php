<?php

namespace Chuckbe\Chuckcms\Actions\Forms;

use Chuckbe\Chuckcms\Chuck\Support\TagParser;
use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Models\FormEntry;
use Illuminate\Http\Request;

class BuildFormMailDataAction
{
    /**
     * Assemble the $mailData array a single FormActionMail send needs.
     * The [field] placeholders inside any string value are substituted
     * with the corresponding request input. The 'files' key, when set
     * to 'true', is rewritten to the list of file paths recorded on
     * the stored entry.
     */
    public function __invoke(Form $form, array $sendConfig, Request $request, FormEntry $entry): array
    {
        $formSlug = $request->input('_form_slug');

        $mailData = [];
        foreach ($sendConfig as $key => $value) {
            $mailData[$key] = $this->interpolatePlaceholders($value, $formSlug, $request);

            if ($key === 'files' && $value === 'true') {
                $mailData[$key] = $this->resolveAttachmentPaths($form, $entry);
            }
        }

        return $mailData;
    }

    private function interpolatePlaceholders(string $value, string $formSlug, Request $request): string
    {
        foreach (TagParser::between($value, '[', ']') as $token) {
            if (strpos($token, $formSlug) !== false) {
                $value = str_replace('['.$token.']', $request->input($token), $value);
            }
        }

        return $value;
    }

    private function resolveAttachmentPaths(Form $form, FormEntry $entry): array
    {
        $paths = [];
        foreach ($form->form['fields'] as $fieldKey => $fieldValue) {
            if ($fieldValue['type'] === 'file') {
                $paths[] = $entry->entry[$fieldKey];
            }
        }

        return $paths;
    }
}
