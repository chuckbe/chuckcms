<?php

namespace Chuckbe\Chuckcms\Actions\Forms;

use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Models\FormEntry;
use Chuckbe\Chuckcms\Requests\Forms\DeleteFormRequest;

class DeleteFormAction
{
    /**
     * Delete a form together with all its stored entries.
     *
     * Returns the legacy tri-state string contract the frontend JS
     * relies on:
     *   'success' / 'error' / 'false'
     */
    public function __invoke(DeleteFormRequest $request): string
    {
        $form = Form::find($request->input('form_id'));
        if ($form === null) {
            return 'false';
        }

        FormEntry::where('slug', $form->slug)->delete();

        return $form->delete() ? 'success' : 'error';
    }
}
