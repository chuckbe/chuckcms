@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.forms.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Bewerk formulier
    </div>
  </div>
  <div class="card-block">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-transparent">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-tabs-linetriangle" data-init-reponsive-tabs="dropdownfx">
            <li class="nav-item">
              <a href="#" class="active" data-toggle="tab" data-target="#fsettings"><span>Instellingen</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#ffields"><span>Velden</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#factions"><span>Acties</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#fbuttons"><span>Knop</span></a>
            </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="fsettings">
              <div class="row column-seperation">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Titel</label>
                        <input type="text" class="form-control" placeholder="Titel" id="form_title" name="form_title" value="{{ $form->title }}" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Slug</label>
                        <input type="text" class="form-control" placeholder="Slug" id="form_slug" name="form_slug" value="{{ $form->slug }}" required disabled>
                        <input type="hidden" class="form-control" placeholder="Slug" id="form_slug" name="form_slug" value="{{ $form->slug }}" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Bestanden toegestaan</label>
                        <select class="full-width" data-init-plugin="select2" name="files_allowed" data-minimum-results-for-search="-1">
            							<option value="true" @if($form->form['files'] == 'true') selected @endif>Ja</option>
            							<option value="false" @if($form->form['files'] !== 'true') selected @endif>Nee</option>
            						</select>
                      </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="ffields">
              @foreach($form->form['fields'] as $fKey => $fValue)
              <div class="row field-input-group">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Slug</label>
                        <input type="text" class="form-control" placeholder="Veld Slug" id="fields_slug" name="fields_slug[]" value="{{ str_replace($form->slug . '_', '', $fKey) }}" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Label</label>
                        <input type="text" class="form-control" placeholder="Veld Label" id="fields_label" name="fields_label[]" value="{{ $fValue['label'] }}" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Type</label>
                        <input type="text" class="form-control" placeholder="Veld Type" id="fields_type" name="fields_type[]" value="{{ $fValue['type'] }}" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group form-group-default required ">
                        <label>Veld Class</label>
                        <input type="text" class="form-control" placeholder="Veld Class" id="fields_class" name="fields_class[]" value="{{ $fValue['class'] }}" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group form-group-default required ">
                        <label>Veld Placeholder</label>
                        <input type="text" class="form-control" placeholder="Veld Placeholder" id="fields_placeholder" name="fields_placeholder[]" value="{{ $fValue['placeholder'] }}" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group form-group-default required ">
                        <label>Veld Validatie</label>
                        <input type="text" class="form-control" placeholder="Veld validatie" id="fields_validation" name="fields_validation[]" value="{{ $fValue['validation'] }}" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group form-group-default required ">
                        <label>Veld Waarde</label>
                        <input type="text" class="form-control" placeholder="waarde van veld" id="fields_value" name="fields_value[]" value="{{ $fValue['value'] ? $fValue['value'] : ' ' }}" required>
                      </div>
                    </div>
                  </div>
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
                    </div>{{-- 
                    <div class="col-md-2">
                      <div class="form-group form-group-default">
                        <button class="btn btn-primary" id="add_field_attribute_btn"><i class="fa fa-plus"></i></button>
                      </div>
                    </div> --}}
                  </div>
                  <div class="form-group form-group-default">
                    <label>Verplicht veld</label>
                    <select class="full-width" data-init-plugin="select2" name="fields_required[]" data-minimum-results-for-search="-1">
                      <option value="true" @if($fValue['required'] == 'true') selected @endif>Ja</option>
                      <option value="false" @if($fValue['required'] !== 'true') selected @endif>Nee</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              @endforeach
              <div class="row">
                <div class="col-lg-6">
                  <button class="btn btn-primary btn-lg" id="add_extra_field_btn"><i class="fa fa-plus"></i> Extra veld toevoegen</button>
                </div>
                <div class="col-lg-6">
                  <button class="btn btn-warning btn-lg" id="remove_last_field_btn" @if(count($form->form['fields']) == 1) style="display:none;" @endif><i class="fa fa-minus"></i> Laatste veld verwijderen</button>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="factions">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Submissies opslaan in databank</label>
                        <select class="full-width" data-init-plugin="select2" name="action_store" data-minimum-results-for-search="-1">
                          <option value="true" @if($form->form['actions']['store'] == 'true') selected @endif>Ja</option>
                          <option value="false" @if($form->form['actions']['store'] !== 'true') selected @endif>Nee</option>
                        </select>
                      </div>
                      <hr>
                      <div class="form-group form-group-default">
                        <label>Submissies verzenden</label>
                        <select class="full-width" data-init-plugin="select2" name="action_send" data-minimum-results-for-search="-1">
                          <option value="true" @if($form->form['actions']['send'] !== 'false') selected @endif>Ja</option>
                          <option value="false" @if($form->form['actions']['send'] == 'false') selected @endif>Nee</option>
                        </select>
                      </div>
                      <hr>
                </div>
              </div>

              <div class="submissions_container_wrapper" @if($form->form['actions']['send'] == 'false') style="display:none;" @endif>
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
                        <select class="full-width" data-init-plugin="select2" name="action_send_files[]" data-minimum-results-for-search="-1">
                          <option value="true" @if($sendValue['files'] == 'true') selected @endif>Ja</option>
                          <option value="false" @if($sendValue['files'] !== 'true') selected @endif>Nee</option>
                        </select>
                      </div>
                      <hr>
                  </div>
                </div>
                @endforeach
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <button class="btn btn-primary btn-lg" id="add_extra_action_btn" @if($form->form['actions']['send'] == 'false') style="display:none;" @endif><i class="fa fa-plus"></i> Extra actie toevoegen</button>
                </div>
                <div class="col-lg-6">
                  <button class="btn btn-warning btn-lg" id="remove_last_action_btn" @if(count($form->form['actions']['send']) == 1) style="display:none;" @endif><i class="fa fa-minus"></i> Laatste actie verwijderen</button>
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

          </div>

          <div class="tab-pane fade" id="fbuttons">
              <div class="row">
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
            </div>
          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <input type="hidden" name="form_id" value="{{ $form->id }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a type="button" href="{{ route('dashboard.pages') }}" class="btn btn-default btn-cons pull-right">Annuleren</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END card -->
</form>
</div>
<!-- END CONTAINER FLUID -->


@endsection

@section('css')
	
@endsection

@section('scripts')
	
	<script>
		$( document ).ready(function() { 
			$("#page_title").keyup(function(){
			    var text = $(this).val();
			    slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
			    $("#page_slug").val(slug_text);
          $("#page_slug_hidden").val(slug_text);    
			});

      $('#add_extra_field_btn').click(function(){
        $('.field_row_container:first').clone().appendTo('.field_container_wrapper');
        if($('.field_row_container').length > 1){
          $('#remove_last_field_btn').show();
        }
      });

      $('#remove_last_field_btn').click(function(){
        if($('.field_row_container').length > 1){
          $('.field_row_container:last').remove();
          if($('.field_row_container').length == 1){
            $('#remove_last_field_btn').hide();
          }
        }
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