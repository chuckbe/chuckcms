<?php

namespace Chuckbe\Chuckcms\Controllers;

use Chuckbe\Chuckcms\Models\Form;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    private $form;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function index()
    {
        $forms = $this->form->get();
        
        return view('chuckcms::backend.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('chuckcms::backend.forms.create');
    }

    public function save(Request $request)
    {
        $forms = $this->form->get();
        
        return view('chuckcms::backend.forms.index', compact('forms'));
    }

    public function postForm(Request $request)
    {
        $forms = $this->form->get();
        
        return view('chuckcms::backend.forms.index', compact('forms'));
    }
}
