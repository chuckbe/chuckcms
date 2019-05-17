<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Mail\FormActionMail;
use Chuckbe\Chuckcms\Models\Form;
use Chuckbe\Chuckcms\Models\FormEntry;
use Chuckbe\Chuckcms\Models\Template;

use Mail;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FormController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $form;
    private $formEntry;
    private $template;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Form $form, FormEntry $formEntry, Template $template)
    {
        $this->form = $form;
        $this->formEntry = $formEntry;
        $this->template = $template;
    }

    public function index()
    {
        $forms = $this->form->get();
        
        return view('chuckcms::backend.forms.index', compact('forms'));
    }

    public function create()
    {
        $emailTemplates = $this->template->getEmailTemplates();
        return view('chuckcms::backend.forms.create', compact('emailTemplates'));
    }

    public function edit($slug)
    {
        $form = $this->form->getBySlug($slug);
        $emailTemplates = $this->template->getEmailTemplates();
        return view('chuckcms::backend.forms.edit', compact('form', 'emailTemplates'));
    }

    public function save(Request $request)
    {
        $form = [];
        $form_slug = $request->get('form_slug');
        $fields_slug = $request->get('fields_slug');
        $countFS = count($fields_slug);
        for ($i=0; $i < $countFS; $i++) { 
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['label'] = $request->get('fields_label')[$i];
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['type'] = $request->get('fields_type')[$i];
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['class'] = $request->get('fields_class')[$i];
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['parentclass'] = $request->get('fields_parentclass')[$i];
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['placeholder'] = $request->get('fields_placeholder')[$i];
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['validation'] = $request->get('fields_validation')[$i];
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['value'] = $request->get('fields_value')[$i];
            $countFAN = count(explode(';',$request->get('fields_attributes_name')[$i]));
            for ($k=0; $k < $countFAN; $k++) { 
                $form['fields'][$form_slug . '_' . $fields_slug[$i]]['attributes'][explode(';',$request->get('fields_attributes_name')[$i])[$k]] = explode(';',$request->get('fields_attributes_value')[$i])[$k];
            }
            $form['fields'][$form_slug . '_' . $fields_slug[$i]]['required'] = $request->get('fields_required')[$i];
        }

        $form['actions']['store'] = $request->get('action_store');
        
        if($request->get('action_send') !== 'false') {
            $countActions = count($request->get('action_send_slug'));
            for ($g=0; $g < $countActions; $g++) { 
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['to'] = $request->get('action_send_to')[$g];
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['to_name'] = $request->get('action_send_to_name')[$g];
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['from'] = $request->get('action_send_from')[$g];
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['from_name'] = $request->get('action_send_from_name')[$g];
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['subject'] = $request->get('action_send_subject')[$g];
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['body'] = $request->get('action_send_body')[$g];
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['files'] = $request->get('action_send_files')[$g];
                $form['actions']['send'][$request->get('action_send_slug')[$g]]['template'] = $request->get('action_send_template')[$g];
            }

        } else {
            $form['actions']['send'] = false;
        }
        $form['actions']['redirect'] = $request->get('action_redirect');

        $form['files'] = $request->get('files_allowed');

        $form['button']['class'] = $request->get('button_class');
        $form['button']['label'] = $request->get('button_label');
        $form['button']['id'] = $request->get('button_id');

        // updateOrCreate the site
        Form::updateOrCreate(
            ['id' => $request->get('form_id')],
            ['title' => $request->get('form_title'),
            'slug' => $request->get('form_slug'),
            'form' => $form]
        );
        
        return redirect()->route('dashboard.forms');
    }

    public function postForm(Request $request)
    {
        $slug = $request->get('_form_slug');
        $form = $this->form->getBySlug($slug);
        $rules = $form->getRules();
        $this->validate(request(), $rules);
        $store = $form->storeEntry($request);
        if ($store !== 'error') {
            //send emails 
            if($form->form['actions']['send'] !== false){
                foreach ($form->form['actions']['send'] as $sendKey => $sendValue) {
                    $mailData = $form->getMailData($sendValue, $request, $store);
                    Mail::send(new FormActionMail($mailData));
                }
            }
            return redirect()->to($form->form['actions']['redirect']);
        } else {
            // error catching ... ?
        }
        
        return view('chuckcms::backend.forms.index', compact('forms'));
    }

    /**
     * Delete the form.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string $status
     */
    public function delete(Request $request)
    {
        // AUTHORIZE ... COMES HERE
        $status = $this->form->deleteById($request->get('form_id'));
        return $status;
    }

    /**
     * Show the form entries.
     *
     * @param  $slug
     * @return \Illuminate\View\View
     */
    public function entries($slug)
    {
        // AUTHORIZE ... COMES HERE
        $form = $this->form->getBySlug($slug);
        $entries = $this->formEntry->getBySlug($slug);
        return view('chuckcms::backend.forms.entries', compact('form', 'entries'));
    }

    /**
     * Show the form entry.
     *
     * @param  $slug
     * @param  $id
     * @return \Illuminate\View\View
     */
    public function entry($slug, $id)
    {
        // AUTHORIZE ... COMES HERE
        $form = $this->form->getBySlug($slug);
        $entry = $this->formEntry->getById($id);
        return view('chuckcms::backend.forms.entries.index', compact('form', 'entry'));
    }
}
