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
     * Handle a public form submission: persist the entry and fire any
     * configured email actions. Returns the redirect target string
     * configured on the form, or null if the store step failed.
     */
    public function __invoke(SubmitFormRequest $request): ?string
    {
        $form = Form::where('slug', $request->input('_form_slug'))->first();
        if ($form === null) {
            return null;
        }

        $store = ($this->storeFormEntry)($form, $request);
        if ($store === 'error') {
            return null;
        }

        if ($store instanceof FormEntry) {
            $this->dispatchSendActions($form, $request, $store);
        }

        return $form->form['actions']['redirect'];
    }

    private function dispatchSendActions(Form $form, SubmitFormRequest $request, FormEntry $entry): void
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
