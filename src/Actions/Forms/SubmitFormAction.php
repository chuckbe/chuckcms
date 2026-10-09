<?php

namespace Chuckbe\Chuckcms\Actions\Forms;

use Chuckbe\Chuckcms\Mail\FormActionMail;
use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Models\FormEntry;
use Chuckbe\Chuckcms\Requests\Forms\SubmitFormRequest;
use Illuminate\Support\Facades\Mail;

class SubmitFormAction
{
    public function __construct(
        private StoreFormEntryAction $storeFormEntry,
        private BuildFormMailDataAction $buildFormMailData,
    ) {
    }

    /**
     * Handle a public form submission: persist the entry (when the form
     * stores entries) and fire any configured email actions. Mail is sent
     * whether or not the entry was stored. Returns the redirect target
     * configured on the form, which may be null.
     */
    public function __invoke(SubmitFormRequest $request): ?string
    {
        $form = Form::where('slug', $request->input('_form_slug'))->firstOrFail();

        $store = ($this->storeFormEntry)($form, $request);
        abort_if($store === 'error', 500, 'Form entry could not be saved.');

        $this->dispatchSendActions($form, $request, $store instanceof FormEntry ? $store : null);

        return $form->form['actions']['redirect'] ?? null;
    }

    private function dispatchSendActions(Form $form, SubmitFormRequest $request, ?FormEntry $entry): void
    {
        $sendActions = $form->form['actions']['send'] ?? false;
        if ($sendActions === false) {
            return;
        }

        foreach ($sendActions as $sendConfig) {
            $mailData = ($this->buildFormMailData)($form, $sendConfig, $request, $entry);
            Mail::send(new FormActionMail($mailData));
        }
    }
}
