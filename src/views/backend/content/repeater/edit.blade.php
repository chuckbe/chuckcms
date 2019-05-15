@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.content.repeaters.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Bewerk repeater: {{ $repeater->slug }}
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
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="fsettings">
              <div class="row column-seperation">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Slug</label>
                        <input type="text" class="form-control" placeholder="Slug" id="content_slug" name="content_slug" value="{{ $repeater->slug }}" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Type Content</label>
                        <select class="full-width select2" data-init-plugin="select2" name="content_type" data-minimum-results-for-search="-1">
                          <option value="repeater" @if($repeater->type == 'repeater') selected @endif>Repeater</option>
                          <option value="module" @if($repeater->type == 'module') selected @endif>Module</option>
                        </select>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Bestanden toegestaan</label>
                        <select class="full-width select2" data-init-plugin="select2" name="files_allowed" data-minimum-results-for-search="-1">
            							<option value="true" @if($repeater->content['files'] == 'true') selected @endif>Ja</option>
            							<option value="false" @if($repeater->content['files'] == 'false') selected @endif>Nee</option>
            						</select>
                      </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="ffields">
              <div class="field_container_wrapper">
              @foreach($repeater->content['fields'] as $fKey => $fValue)
              <div class="row field-input-group field_row_container">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Veld Slug</label>
                        <input type="text" class="form-control" placeholder="Veld Slug" id="fields_slug" name="fields_slug[]" value="{{ str_replace($repeater->slug . '_', '', $fKey) }}" required>
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
                        <select class="full-width select2 form-control" data-init-plugin="select2" id="fields_type" name="fields_type[]" data-minimum-results-for-search="-1" required>
                            <option value="text" @if($fValue['type'] == 'text') selected @endif>Text</option>
                            <option value="email" @if($fValue['type'] == 'email') selected @endif>E-mail</option>
                            <option value="password" @if($fValue['type'] == 'password') selected @endif>Password</option>
                            <option value="image_link" @if($fValue['type'] == 'image_link') selected @endif>Image</option>
                            <option value="file" @if($fValue['type'] == 'file') selected @endif>File</option>
                            <option value="textarea" @if($fValue['type'] == 'textarea') selected @endif>Textarea</option>
                            <option value="wysiwyg" @if($fValue['type'] == 'wysiwyg') selected @endif>WYSIWYG</option>
                            <option value="select2" @if($fValue['type'] == 'select2') selected @endif>Select2 (single)</option>
                            <option value="multiselect2" @if($fValue['type'] == 'multiselect2') selected @endif>Select2 (multiple)</option>
                            <option value="date" @if($fValue['type'] == 'date') selected @endif>Datepicker</option>
                            <option value="datetime" @if($fValue['type'] == 'datetime') selected @endif>Datetime picker</option>
                          </select>
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
                      <div class="form-group form-group-default">
                        <label>Veld Waarde</label>
                        <input type="text" class="form-control" placeholder="waarde van veld" id="fields_value" name="fields_value[]" value="{{ $fValue['value'] ? $fValue['value'] : ' ' }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group form-group-default required">
                        <label>Veld Attribute Naam</label>
                        <input type="text" class="form-control" placeholder="Veld Attribute Naam" id="fields_attributes_name" name="fields_attributes_name[]" value="@foreach($fValue['attributes'] as $attrKey => $attrValue){{$loop->iteration > 1 ? ';' : ''}}{{$attrKey}}@endforeach" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group form-group-default required">
                        <label>Veld Attribute Waarde</label>
                        <input type="text" class="form-control" placeholder="Veld Attribute Waarde" id="fields_attributes_value" name="fields_attributes_value[]" value="@foreach($fValue['attributes'] as $attrKey => $attrValue){{$loop->iteration > 1 ? ';' : ''}}{{$attrValue}}@endforeach" required>
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
                    <select class="full-width select2" data-init-plugin="select2" name="fields_required[]" data-minimum-results-for-search="-1">
                      <option value="true" @if($fValue['required'] == 'true') selected @endif>Ja</option>
                      <option value="false" @if($fValue['required'] !== 'true') selected @endif>Nee</option>
                    </select>
                  </div>
                  <div class="form-group form-group-default">
                      <label>Toon in tabel</label>
                      <select class="full-width select2" data-init-plugin="select2" name="fields_table[]" data-minimum-results-for-search="-1">
                        <option value="true" @if($fValue['table'] == 'true') selected @endif>Ja</option>
                        <option value="false" @if($fValue['table'] !== 'true') selected @endif>Nee</option>
                      </select>
                  </div>
                <hr>
                </div>
              </div>
              @endforeach
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <button class="btn btn-primary btn-lg" type="button" id="add_extra_field_btn"><i class="fa fa-plus"></i> Extra veld toevoegen</button>
                </div>
                <div class="col-lg-6">
                  <button class="btn btn-warning btn-lg" type="button" id="remove_last_field_btn" @if(count($repeater->content['fields']) == 1) style="display:none;" @endif><i class="fa fa-minus"></i> Laatste veld verwijderen</button>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="factions">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Submissies opslaan in databank</label>
                        <select class="full-width select2" data-init-plugin="select2" name="action_store" data-minimum-results-for-search="-1" required>
                          <option value="true" @if($repeater->content['actions']['store'] == 'true') selected @endif>Ja</option>
                          <option value="false" @if($repeater->content['actions']['store'] == 'false') selected @endif>Nee</option>
                        </select>
                      </div>
                      <hr>
                      <div class="form-group form-group-default required ">
                        <label>Detailpagina voor entries</label>
                        <select class="full-width select2" data-init-plugin="select2" name="action_detail" data-minimum-results-for-search="-1" required>
                          <option value="true" @if($repeater->content['actions']['detail'] !== 'false') selected @endif>Ja</option>
                          <option value="false" @if($repeater->content['actions']['detail'] == 'false') selected @endif>Nee</option>
                        </select>
                      </div>
                      <hr>
                </div>
              </div>

              <div class="submissions_container_wrapper" @if($repeater->content['actions']['detail'] == 'false') style="display:none;" @endif>
                <div class="row submissions_container_row">
                  <div class="col-lg-12">
                    <div class="form-group form-group-default required ">
                      <label>Detailpagina URL</label>
                      <input type="text" class="form-control" placeholder="Detailpagina URL" id="action_detail_url" name="action_detail_url" @if($repeater->content['actions']['detail'] !== 'false') value="{{ $repeater->content['actions']['detail']['url'] !== 'null' ? $repeater->content['actions']['detail']['url'] : 'null' }}" @endif>
                    </div>
                    <div class="form-group form-group-default">
                      <label>Pagina-type</label>
                      <select class="full-width select2" data-init-plugin="select2" name="action_detail_page" data-minimum-results-for-search="-1">
                        @foreach($pageViews as $template => $page)
                        <optgroup label="Template: '{{ $template }}'">
                          @foreach($page['files'] as $file)
                            <option value="{{ $page['hintpath'] . '::templates.' . $template . '.' . $file }}" @if($repeater->content['actions']['detail'] !== 'false') @if($repeater->content['actions']['detail']['page'] == $page['hintpath'] . '::templates.' . $template . '.' . $file) selected @endif @endif>{{ $file }} - {{ $template }}</option>
                          @endforeach
                        </optgroup>
                        @endforeach
                      </select>
                    </div>
                    <hr>
                  </div>
                </div>
              </div>
          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <input type="hidden" name="content_id" value="{{ $repeater->id }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a href="{{ route('dashboard.content.repeaters') }}" class="pull-right"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
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
			function destroySelect2(){
        var $select = $('.select2').select2();
        $select.each(function(i,item){
          $(item).select2("destroy");
        });
      };

      function initSelect2(){
        $('.select2').select2();
      };

      $("#content_slug").keyup(function(){
			    var text = $(this).val();
			    slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
			    $("#content_slug").val(slug_text);  
			});

      $('#add_extra_field_btn').click(function(){
        destroySelect2();
        $('.field_row_container:first').clone().appendTo('.field_container_wrapper');
        if($('.field_row_container').length > 1){
          $('#remove_last_field_btn').show();
        }
        initSelect2();
      });

      $('#remove_last_field_btn').click(function(){
        if($('.field_row_container').length > 1){
          $('.field_row_container:last').remove();
          if($('.field_row_container').length == 1){
            $('#remove_last_field_btn').hide();
          }
        }
      });

      $('select[name=action_detail]').change(function(){
        if($('select[name=action_detail]').val() == 'true'){
          $('.submissions_container_wrapper').show();
          $('#add_extra_action_btn').show();
        }

        if($('select[name=action_detail]').val() == 'false'){
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