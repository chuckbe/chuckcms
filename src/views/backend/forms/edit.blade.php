@extends('chuckcms::backend.layouts.base')

@section('content')
<!-- START CONTAINER FLUID -->
<div class="container p-3 min-height">
  <div class="row">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.forms') }}">Formulieren</a></li>
                <li class="breadcrumb-item active" aria-current="Gebruikers">Bewerk formulier</li>
            </ol>
        </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="my-3">
        <ul class="nav nav-tabs justify-content-start" id="formTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="fsettings-tab" data-target="#tab_resource_fsettings" data-toggle="tab" href="#" role="tab" aria-controls="fsettings" aria-selected="true">Instellingen</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="ffields-tab" data-target="#tab_resource_ffields" data-toggle="tab" href="#" role="tab" aria-controls="ffields" aria-selected="false">Velden</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="factions-tab" data-target="#tab_resource_factions" data-toggle="tab" href="#" role="tab" aria-controls="#factions" aria-selected="false">Acties</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="fbuttons-tab" data-target="#tab_resource_fbuttons" data-toggle="tab" href="#" role="tab" aria-controls="#fbuttons" aria-selected="false">Knop</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <form action="{{ route('dashboard.forms.save') }}" method="POST">
    <div class="row tab-content bg-light shadow-sm rounded p-3 mb-3 mx-1" id="formTabContent">
     {{-- fsettings-tab-starts --}}
      <div class="col-sm-12 tab-pane fade show active" id="tab_resource_fsettings" role="tabpanel" aria-labelledby="fsettings-tab">
        <div class="row column-seperation">
          <div class="col-lg-12">
            <div class="form-group form-group-default required ">
              <label>Titel</label>
              <input type="text" class="form-control" placeholder="Titel" id="form_title" name="form_title" value="{{ $form->title }}" required>
            </div>
            <div class="form-group form-group-default required ">
              <label>Slug</label>
              <input type="text" class="form-control" placeholder="Slug" id="form_slug" name="form_slug" value="{{ $form->slug }}" required readonly>
            </div>
            <div class="form-group form-group-default required ">
              <label>Bestanden toegestaan</label>
              <select class="full-width select2 form-control" data-init-plugin="select2" name="files_allowed" data-minimum-results-for-search="-1">
            		<option value="true" @if($form->form['files'] == 'true' || $form->form['files'] == true) selected @endif>Ja</option>
            		<option value="false" @if($form->form['files'] !== 'true' || $form->form['files'] !== true) selected @endif>Nee</option>
            	</select>
            </div>
          </div>
        </div>
      </div>{{-- fsettings-tab-ends --}}
      {{-- ffields-tab-starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_ffields" role="tabpanel" aria-labelledby="ffields-tab">
        <div class="row column-seperation">         
          <div class="field_container_wrapper ui-state-default w-100" id="field_container_wrapper">
            @foreach($form->form['fields'] as $fKey => $fValue)
              <div class="row field-input-group field_row_container">
                <div class="col-lg-12 well" type="button" data-toggle="collapse" data-target="#{{ $fKey }}" aria-expanded="false" aria-controls="{{ $fKey }}">
                  <h4 class="card-title form_well_title" style="margin-left:1.5rem;"><span class="form_well_title_label">{{ $fValue['label'] }}</span> (<span class="form_slug_text_label">{{ $form->slug }}_</span><span class="form_well_title_slug">{{ str_replace($form->slug . '_', '', $fKey) }}</span>) <span class="form_well_title_type label label-inverse">{{ $fValue['type'] }}</span> <span class="label label-danger pull-right form_well_remove_btn" style="margin:10px 10px auto auto"><i class="fa fa-trash"></i></span></h4>
                </div>
                <div class="col-lg-12 collapse" id="{{ $fKey }}">
                  {{-- row starts --}}
                  <div class="row" style="margin-top:1.5rem;">
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Label</label>
                        <input type="text" class="form-control fields_label" placeholder="Veld Label" name="fields_label[]" value="{{ $fValue['label'] }}" required>
                      </div>
                    </div>
                    <input type="hidden" class="fields_slug" placeholder="Veld Slug" name="fields_slug[]" value="{{ str_replace($form->slug . '_', '', $fKey) }}" readonly required>
                    <input type="hidden" class="fields_type" name="fields_type[]" value="{{ $fValue['type'] }}" readonly required>
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Class</label>
                        <input type="text" class="form-control" placeholder="Veld Class" id="fields_class" name="fields_class[]" value="{{ $fValue['class'] }}" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default ">
                        <label>Ouder Veld Class</label>
                        <input type="text" class="form-control" placeholder="Ouder Veld Class" id="fields_parentclass" name="fields_parentclass[]" value="{{ array_key_exists('parentclass', $fValue) ? $fValue['parentclass'] : '' }}" >
                      </div>
                    </div>
                  </div>
                  {{-- row ends here --}}
                  {{-- row starts --}}
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Placeholder</label>
                        <input type="text" class="form-control" placeholder="Veld Placeholder" id="fields_placeholder" name="fields_placeholder[]" value="{{ $fValue['placeholder'] }}" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default">
                        <label>Veld Waarde</label>
                        <input type="text" class="form-control" placeholder="waarde van veld" id="fields_value" name="fields_value[]" value="{{ $fValue['value'] ? $fValue['value'] : '' }}">
                      </div>
                    </div>
                     <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Validatie</label>
                        <input type="text" class="form-control" placeholder="Veld validatie" id="fields_validation" name="fields_validation[]" value="{{ $fValue['validation'] }}" required>
                      </div>
                    </div>
                  </div>
                  {{-- row ends here --}}
                  {{-- row starts --}}
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group form-group-default required">
                        <label>Veld Attribute Naam</label>
                        <input type="text" class="form-control" placeholder="Veld Attribute Naam" id="fields_attributes_name" name="fields_attributes_name[]" value="@foreach($fValue['attributes'] as $attrKey => $attrValue){{$attrKey}}@if($loop->iteration > 1);@endif @endforeach" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group form-group-default required">
                        <label>Veld Attribute Waarde</label>
                        <input type="text" class="form-control" placeholder="Veld Attribute Waarde" id="fields_attributes_value" name="fields_attributes_value[]" value="@foreach($fValue['attributes'] as $attrKey => $attrValue){{$attrValue}}@if($loop->iteration > 1);@endif @endforeach" required>
                      </div>
                    </div>
                  </div>
                  {{-- row ends here --}}
                  <div class="form-group form-group-default">
                    <label>Verplicht veld</label>
                    <select class="full-width select2 form-control" data-init-plugin="select2" name="fields_required[]" data-minimum-results-for-search="-1">
                      <option value="true" @if($fValue['required'] == 'true') selected @endif>Ja</option>
                      <option value="false" @if($fValue['required'] !== 'true') selected @endif>Nee</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-12">
                  <hr>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        {{-- row ends here --}}
        <div class="row column-seperation">
          <div class="col-md-3">
            <div class="form-group">
              <select class="full-width select2 form-control" data-init-plugin="select2" id="new_form_element_type" placeholder="Select a type for a new field" data-minimum-results-for-search="-1" required>
                <option value="text">Text</option>
                <option value="email" >E-mail</option>
                <option value="checkbox" >Checkbox (single)</option>
                <option value="password">Password</option>
                <option value="file">File</option>
                <option value="textarea">Textarea</option>
                <option value="select2">Select2 (single)</option>
                <option value="multiselect2">Select2 (multiple)</option>
                <option value="date">Datepicker</option>
                <option value="datetime">Datetime picker</option>
              </select> 
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Label for new field" id="new_form_element_label">
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Slug for new field" id="new_form_element_slug">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" id="add_extra_field_btn"><i class="fa fa-plus"></i> Veld toevoegen</button>
                </div>
            </div>
            <small class="text-danger add_extra_field_warning" style="display:none;">Enter a slug to add a field!</small>
          </div>
        </div>
        {{-- row ends here --}}
      </div>{{-- ffields-tab-ends --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_factions" role="tabpanel" aria-labelledby="factions-tab">
        <div class="row column-seperation">
          <div class="col-lg-12">
            <div class="form-group form-group-default required ">
              <label>Submissies opslaan in databank</label>
              <select class="full-width select2 form-control" data-init-plugin="select2" name="action_store" data-minimum-results-for-search="-1">
                <option value="true" @if($form->form['actions']['store'] == 'true') selected @endif>Ja</option>
                <option value="false" @if($form->form['actions']['store'] !== 'true') selected @endif>Nee</option>
              </select>
            </div>
            <hr>
            <div class="form-group form-group-default">
              <label>Submissies verzenden</label>
              <select class="full-width select2 form-control" data-init-plugin="select2" name="action_send" data-minimum-results-for-search="-1">
                <option value="true" @if($form->form['actions']['send'] !== false) selected @endif>Ja</option>
                <option value="false" @if($form->form['actions']['send'] == false) selected @endif>Nee</option>
              </select>
            </div>
            <hr>
          </div>
        </div>
        <div class="submissions_container_wrapper" @if($form->form['actions']['send'] == false) style="display:none;" @endif>
          @if($form->form['actions']['send'] !== false && (is_array($form->form['actions']['send']) && count($form->form['actions']['send']) > 0 ))
          @foreach($form->form['actions']['send'] as $sendKey => $sendValue)
            <div class="row submissions_container_row">
              <div class="col-lg-12">
                <div class="form-group form-group-default required ">
                  <label>Slug</label>
                  <input type="text" class="form-control" placeholder="slug" id="action_send_slug" name="action_send_slug[]" value="{{ $sendKey }}" required>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-group-default required ">
                      <label>E-mailadres geaddresseerde</label>
                      <input type="text" class="form-control" placeholder="E-mailadres Geaddresseerde" id="action_send_to" name="action_send_to[]" value="{{ $sendValue['to'] }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-default required ">
                      <label>Naam geaddresseerde</label>
                      <input type="text" class="form-control" placeholder="Naam Geaddresseerde" id="action_send_to_name" name="action_send_to_name[]" value="{{ $sendValue['to_name'] }}" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-group-default required ">
                      <label>E-mailadres afzender</label>
                      <input type="text" class="form-control" placeholder="E-mailadres Afzender" id="action_send_from" name="action_send_from[]" value="{{ $sendValue['from'] }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-default required ">
                      <label>Naam afzender</label>
                      <input type="text" class="form-control" placeholder="Naam Afzender" id="action_send_from_name" name="action_send_from_name[]" value="{{ $sendValue['from_name'] }}" required>
                    </div>
                  </div>
                </div>
                <div class="form-group form-group-default required ">
                  <label>Onderwerp</label>
                  <input type="text" class="form-control" placeholder="Onderwerp" id="action_send_subject" name="action_send_subject[]" value="{{ $sendValue['subject'] }}" required>
                </div>
                <div class="form-group form-group-default required ">
                  <label>Body</label>
                  <textarea id="meta_keywords" name="action_send_body[]" placeholder="Hier gaat je bericht in" style="min-height:210px!important;" class="form-control" required>{{ $sendValue['body'] }}</textarea>
                </div>
                <div class="form-group form-group-default">
                  <label>Bestanden verzenden</label>
                  <select class="full-width select2 form-control" data-init-plugin="select2" name="action_send_files[]" data-minimum-results-for-search="-1">
                    <option value="true" @if($sendValue['files'] == 'true') selected @endif>Ja</option>
                    <option value="false" @if($sendValue['files'] !== 'true') selected @endif>Nee</option>
                  </select>
                </div>
                <div class="form-group form-group-default">
                  <label>E-mail template</label>
                  <select class="full-width select2 form-control" data-init-plugin="select2" name="action_send_template[]" data-minimum-results-for-search="-1">
                    @foreach($emailTemplates as $template => $emails)
                      <optgroup label="Template: '{{ $template }}'">
                        @foreach($emails['files'] as $file)
                          <option value="{{ $emails['hintpath'] . '::templates.' . $template . '.mails.' . $file }}" @if($sendValue['template'] == $emails['hintpath'] . '::templates.' . $template . '.mails.' . $file) selected @endif>{{ $file }} - {{ $template }}</option>
                        @endforeach
                      </optgroup>
                    @endforeach
                  </select>
                </div>
                <hr>
              </div>
            </div>
          @endforeach
          @else
            <div class="row submissions_container_row">
              <div class="col-lg-12">
                <div class="form-group form-group-default required">
                  <label>Slug</label>
                  <input type="text" class="form-control" placeholder="slug" id="action_send_slug" name="action_send_slug[]">
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-group-default required">
                      <label>E-mailadres geaddresseerde</label>
                      <input type="text" class="form-control" placeholder="E-mailadres Geaddresseerde" id="action_send_to" name="action_send_to[]">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-default required">
                      <label>Naam geaddresseerde</label>
                      <input type="text" class="form-control" placeholder="Naam Geaddresseerde" id="action_send_to_name" name="action_send_to_name[]">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-group-default required">
                      <label>E-mailadres afzender</label>
                      <input type="text" class="form-control" placeholder="E-mailadres Afzender" id="action_send_from" name="action_send_from[]">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-default required">
                      <label>Naam afzender</label>
                      <input type="text" class="form-control" placeholder="Naam Afzender" id="action_send_from_name" name="action_send_from_name[]">
                    </div>
                  </div>
                </div>

                <div class="form-group form-group-default required">
                  <label>Onderwerp</label>
                  <input type="text" class="form-control" placeholder="Onderwerp" id="action_send_subject" name="action_send_subject[]">
                </div>

                <div class="form-group form-group-default required">
                  <label>Body</label>
                  <textarea id="meta_keywords" name="action_send_body[]" placeholder="Hier gaat je bericht in" style="min-height:210px!important;" class="form-control"></textarea>
                </div>

                <div class="form-group form-group-default required">
                  <label>Bestanden verzenden</label>
                  <select class="full-width select2 form-control" data-init-plugin="select2" name="action_send_files[]" data-minimum-results-for-search="-1">
                    <option value="true">Ja</option>
                    <option value="false" selected>Nee</option>
                  </select>
                </div>

                <div class="form-group form-group-default">
                  <label>E-mail template</label>
                  <select class="full-width select2 form-control" data-init-plugin="select2" name="action_send_template[]" data-minimum-results-for-search="-1">
                    @foreach($emailTemplates as $template => $emails)
                      <optgroup label="Template: '{{ $template }}'">
                        @foreach($emails['files'] as $file)
                          <option value="{{ $emails['hintpath'] . '::templates.' . $template . '.mails.' . $file }}">{{ $file }} - {{ $template }}</option>
                        @endforeach
                      </optgroup>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          @endif
        </div>
        <div class="row">
          <div class="col-lg-6">
            <button type="button" class="btn btn-primary btn-lg" id="add_extra_action_btn" @if($form->form['actions']['send'] == 'false') style="display:none;" @endif><i class="fa fa-plus"></i> Extra actie toevoegen</button>
          </div>
          <div class="col-lg-6">
            <button type="button" class="btn btn-warning btn-lg" id="remove_last_action_btn" @if(!is_array($form->form['actions']['send']) || (is_array($form->form['actions']['send']) && count($form->form['actions']['send']) == 1) ) style="display:none;" @endif><i class="fa fa-minus"></i> Laatste actie verwijderen</button>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-lg-12">
            <div class="form-group form-group-default required ">
              <label>Doorsturen naar (URL)</label>
              <input type="text" class="form-control" placeholder="Hyperlink om naar door te sturen" id="action_redirect" name="action_redirect" value="{{ $form->form['actions']['redirect'] }}" required>
            </div>
          </div>
        </div>

      </div>{{-- factions-tab-ends --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_fbuttons" role="tabpanel" aria-labelledby="fbuttons-tab">
        <div class="row column-seperation">
          <div class="col-lg-12">
            <div class="form-group form-group-default required ">
              <label>Label</label>
              <input type="text" class="form-control" placeholder="Label bv. Verzenden" id="button_label" name="button_label" value="{{ $form->form['button']['label'] }}" required>
            </div>
            <div class="form-group form-group-default">
              <label>Class</label>
              <input type="text" class="form-control" placeholder="Class" id="button_class" name="button_class" value="{{ $form->form['button']['class'] }}">
            </div>
            <div class="form-group form-group-default">
              <label>ID</label>
              <input type="text" class="form-control" placeholder="ID" id="button_id" name="button_id" value="{{ $form->form['button']['id'] }}">
            </div>
          </div>
        </div>
      </div>{{-- fbuttons-tab-ends --}}
    </div>{{-- formTabContent ends --}}
    <div class="row">
      <div class="col-sm-12">
        <p class="pull-right">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <input type="hidden" name="form_id" value="{{ $form->id }}">
          <button type="submit" name="create" class="btn btn-success btn-cons pull-right m-1" value="1">Opslaan</button>
          <a href="{{ route('dashboard.forms') }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
        </p>
      </div>
    </div>{{-- form control button row ends --}}
  </form>
</div>
<!-- END CONTAINER FLUID -->


@endsection

@section('css')
	
@endsection

@section('scripts')
	
<script>
$( document ).ready(function() { 
  function destroySelect2(){
    var $select = $('.select2').select2();
    $select.each(function(i,item){
      $(item).select2("destroy");
    });
  };

  function initSelect2(){
    $('.select2').select2();
  };

  $( "#field_container_wrapper" ).sortable({
    revert: true
  });
  
  $('body').on('click', '.form_well_remove_btn', function() {
    if($('.field_row_container').length > 1) {
      $(this).closest('.field_row_container').remove();
    }
  }); 

  $("#new_form_element_slug").keyup(function(){
      var text = $(this).val();
      slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
      $("#new_form_element_slug").val(slug_text);
  });

  $('body').on('keyup', ".fields_label", function(){
      var text = $(this).val();
      $(this).closest('.field_row_container').find('.form_well_title_label').text(text);
  });

  $('body').on('click', '#add_extra_field_btn', function(){
    $('.add_extra_field_warning').hide();
    if($('#new_form_element_slug').val().length == 0 && $('#new_form_element_label').val().length == 0) {
      $('.add_extra_field_warning').show();
      return;
    }

    
    //duplicate the field row
    destroySelect2();
    $('.field_row_container:first').clone().appendTo('.field_container_wrapper');
    
    new_key_id = 'field_'+($('.field_row_container').length);
    $('.field_row_container:last').find('.well').attr('data-target', '#'+new_key_id);
    $('.field_row_container:last').find('.collapse').attr('id', new_key_id);

    new_slug = $('#new_form_element_slug').val();
    $('.field_row_container:last .collapse').find('.fields_slug').val(new_slug);
    $('.field_row_container:last .well').find('.form_well_title_slug').text(new_slug);

    new_label = $('#new_form_element_label').val();
    $('.field_row_container:last .collapse').find('.fields_label').val(new_label);
    $('.field_row_container:last .well').find('.form_well_title_label').text(new_label);

    new_type = $('#new_form_element_type').val();    
    $('.field_row_container:last .collapse').find('.fields_type').val(new_type);
    $('.field_row_container:last .well').find('.form_well_title_type').text(new_type);

    initSelect2();
    $('#new_form_element_slug').val('');//reset new field slug input
    $('#new_form_element_label').val('');//reset new field slug input
  });

  $('select[name=action_send]').change(function(){
    if($('select[name=action_send]').val() == 'true'){
      $('.submissions_container_wrapper').show();
      $('#add_extra_action_btn').show();
      if($('.submissions_container_row').length > 1){
        $('#remove_last_action_btn').show();
      }
    }

    if($('select[name=action_send]').val() == 'false'){
      $('.submissions_container_wrapper').hide();
      $('#add_extra_action_btn').hide();
      $('#remove_last_action_btn').hide();
    }
  });
  

  $('#add_extra_action_btn').click(function(){
    $('.submissions_container_row:first').clone().appendTo('.submissions_container_wrapper');
    if($('.submissions_container_row').length > 1){
      $('#remove_last_action_btn').show();
    }
  });

  $('#remove_last_action_btn').click(function(){
    if($('.submissions_container_row').length > 1){
      $('.submissions_container_row:last').remove();
      if($('.submissions_container_row').length == 1){
        $('#remove_last_action_btn').hide();
      }
    }
  });

});
</script>
@endsection