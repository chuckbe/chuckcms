<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Actions\Forms\CreateFormAction;
use Chuckbe\Chuckcms\Actions\Forms\DeleteFormAction;
use Chuckbe\Chuckcms\Actions\Forms\SaveFormAction;
use Chuckbe\Chuckcms\Actions\Forms\SubmitFormAction;
use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Models\FormEntry;
use Chuckbe\Chuckcms\Models\Template;
use Chuckbe\Chuckcms\Requests\Forms\CreateFormRequest;
use Chuckbe\Chuckcms\Requests\Forms\DeleteFormRequest;
use Chuckbe\Chuckcms\Requests\Forms\SaveFormRequest;
use Chuckbe\Chuckcms\Requests\Forms\SubmitFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class FormController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct(
        private Form $form,
        private FormEntry $formEntry,
        private Template $template,
    ) {
    }

    public function index()
    {
        $forms = $this->form->get();

        return view('chuckcms::backend.forms.index', compact('forms'));
    }

    public function create(CreateFormRequest $request, CreateFormAction $createForm)
    {
        $form = $createForm($request);

        return redirect()->route('dashboard.forms.edit', ['slug' => $form->slug]);
    }

    public function edit($slug)
    {
        $form = Form::where('slug', $slug)->first();
        $emailTemplates = $this->template->getEmailTemplates();

        return view('chuckcms::backend.forms.edit', compact('form', 'emailTemplates'));
    }

    public function save(SaveFormRequest $request, SaveFormAction $saveForm)
    {
        $saveForm($request);

        return redirect()->route('dashboard.forms');
    }

    public function postForm(SubmitFormRequest $request, SubmitFormAction $submitForm)
    {
        $redirect = $submitForm($request);
        if ($redirect === null) {
            return redirect()->route('dashboard.forms');
        }

        return redirect()->to($redirect);
    }

    public function delete(DeleteFormRequest $request, DeleteFormAction $deleteForm): string
    {
        return $deleteForm($request);
    }

    /**
     * Show the form entries.
     *
     * @return \Illuminate\View\View
     */
    public function entries($slug)
    {
        $form = Form::where('slug', $slug)->first();
        $entries = FormEntry::where('slug', $slug)->get();

        return view('chuckcms::backend.forms.entries', compact('form', 'entries'));
    }

    /**
     * Show a specific form entry.
     *
     * @return \Illuminate\View\View
     */
    public function entry($slug, $id)
    {
        $form = Form::where('slug', $slug)->first();
        $entry = FormEntry::find($id);

        return view('chuckcms::backend.forms.entries.index', compact('form', 'entry'));
    }
}
