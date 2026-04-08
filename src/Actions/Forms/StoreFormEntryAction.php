<?php

namespace Chuckbe\Chuckcms\Actions\Forms;

use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Models\FormEntry;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class StoreFormEntryAction
{
    /**
     * Persist a submitted form entry, optionally moving uploaded files
     * to public/files/uploads/ and recording the resulting paths in
     * the entry's JSON payload.
     *
     * Returns the persisted FormEntry on success, the string 'pass'
     * if the form is not configured to store entries, or the string
     * 'error' if the entry could not be saved. Matches the legacy
     * contract the SubmitFormAction depends on.
     */
    public function __invoke(Form $form, Request $request): FormEntry|string
    {
        if (!$this->storeEnabled($form)) {
            return 'pass';
        }

        $entry = new FormEntry();
        $entry->slug = $request->input('_form_slug');
        $entry->entry = $this->collectFieldValues($form, $request);

        if (!$entry->save()) {
            return 'error';
        }

        return $entry;
    }

    private function storeEnabled(Form $form): bool
    {
        $store = $form->form['actions']['store'] ?? false;

        return $store === true || $store === 'true';
    }

    private function filesEnabled(Form $form): bool
    {
        return ($form->form['files'] ?? false) === 'true';
    }

    private function collectFieldValues(Form $form, Request $request): array
    {
        $json = [];
        foreach ($form->form['fields'] as $fieldKey => $fieldValue) {
            if ($fieldValue['type'] !== 'file') {
                $json[$fieldKey] = $request->input($fieldKey);
            }
        }

        if ($this->filesEnabled($form)) {
            foreach ($form->form['fields'] as $fieldKey => $fieldValue) {
                if ($fieldValue['type'] === 'file') {
                    $json[$fieldKey] = $this->storeUploadedFile($request, $fieldKey);
                }
            }
        }

        return $json;
    }

    private function storeUploadedFile(Request $request, string $fieldKey): ?string
    {
        if (!$request->hasFile($fieldKey)) {
            return null;
        }

        /** @var UploadedFile $file */
        $file = $request->file($fieldKey);
        $filename = time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();

        $uploadDir = public_path('/files/uploads/');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $file->move($uploadDir, $filename);

        return '/files/uploads/'.$filename;
    }
}
