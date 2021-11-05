@extends('chuckcms::backend.layouts.base')

@section('content')
<div class="container p-3 min-height">
  <div class="row">
    <div class="col-sm-12">
       <nav aria-label="breadcrumb">
        <ol class="breadcrumb mt-3">
          <li class="breadcrumb-item"><a href="{{ route('dashboard.content.repeaters') }}">Repeaters</a></li>
          <li class="breadcrumb-item active" aria-current="Repeater">Maak een nieuwe repeater</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="my-3">
        <ul class="nav nav-tabs justify-content-start" id="repeaterTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="fsettings-tab" data-target="#tab_resource_fsettings" data-toggle="tab" href="#" role="tab" aria-controls="fsettings" aria-selected="true">Instellingen</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="ffields-tab" data-target="#tab_resource_ffields" data-toggle="tab" href="#" role="tab" aria-controls="ffields" aria-selected="false">Velden</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="factions-tab" data-target="#tab_resource_factions" data-toggle="tab" href="#" role="tab" aria-controls="#factions" aria-selected="false">Acties</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <form action="{{ route('dashboard.content.repeaters.save') }}" method="POST">
    <div class="row tab-content bg-light shadow-sm rounded p-3 mb-3 mx-1" id="repeaterTabContent">
      {{-- fsettings-tab-starts --}}
      <div class="col-sm-12 tab-pane fade show active" id="tab_resource_fsettings" role="tabpanel" aria-labelledby="fsettings-tab">
        <div class="row column-seperation">
          <div class="col-lg-12">
            <div class="form-group form-group-default required ">
              <label>Slug</label>
              <input type="text" class="form-control" placeholder="Slug" id="content_slug" name="content_slug" required>
            </div>
            <div class="form-group form-group-default required ">
              <label>Type Content</label>
              <select class="full-width select2 form-control" data-init-plugin="select2" name="content_type" data-minimum-results-for-search="-1">
                <option value="repeater" selected>Repeater</option>
                <option value="module">Module</option>
              </select>
            </div>
            <div class="form-group form-group-default required ">
              <label>Bestanden toegestaan</label>
              <select class="full-width select2 form-control" data-init-plugin="select2" name="files_allowed" data-minimum-results-for-search="-1">
            		<option value="true">Ja</option>
            		<option value="false" selected>Nee</option>
            	</select>
            </div>
          </div>
        </div>
      </div>{{-- fsettings-tab-ends --}}
      {{-- ffields-tab-starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_ffields" role="tabpanel" aria-labelledby="ffields-tab">
        <div class="field_container_wrapper">
          <div class="row field_row_container">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group form-group-default required ">
                    <label>Veld Slug</label>
                    <input type="text" class="form-control" placeholder="Veld Slug" id="fields_slug" name="fields_slug[]" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group form-group-default required ">
                    <label>Veld Label</label>
                    <input type="text" class="form-control" placeholder="Veld Label" id="fields_label" name="fields_label[]" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group form-group-default required ">
                    <label>Veld Type</label><br>
                    <select class="full-width select2 form-control" data-init-plugin="select2" id="fields_type" name="fields_type[]" data-minimum-results-for-search="-1" required>
                      <option value="text">Text</option>
                      <option value="email">E-mail</option>
                      <option value="password">Password</option>
                      <option value="image_link">Image</option>
                      <option value="file">File</option>
                      <option value="textarea">Textarea</option>
                      <option value="wysiwyg">WYSIWYG</option>
                      <option value="select2">Select2 (single)</option>
                      <option value="multiselect2">Select2 (multiple)</option>
                      <option value="date">Datepicker</option>
                      <option value="datetime">Datetime picker</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group form-group-default required ">
                    <label>Veld Class</label>
                    <input type="text" class="form-control" placeholder="Veld Class" id="fields_class" name="fields_class[]" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group form-group-default required ">
                    <label>Veld Placeholder</label>
                    <input type="text" class="form-control" placeholder="Veld Placeholder" id="fields_placeholder" name="fields_placeholder[]" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group form-group-default required ">
                    <label>Veld Validatie</label>
                    <input type="text" class="form-control" placeholder="Veld validatie" id="fields_validation" name="fields_validation[]" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group form-group-default">
                    <label>Veld Waarde</label>
                    <input type="text" class="form-control" placeholder="waarde van veld" id="fields_value" name="fields_value[]">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group form-group-default required">
                    <label>Veld Attribute Naam</label>
                    <input type="text" class="form-control" placeholder="Veld Attribute Naam" id="fields_attributes_name" name="fields_attributes_name[]" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group form-group-default required">
                    <label>Veld Attribute Waarde</label>
                    <input type="text" class="form-control" placeholder="Veld Attribute Waarde" id="fields_attributes_value" name="fields_attributes_value[]" required>
                  </div>
                </div>
              </div>
              <div class="form-group form-group-default">
                <label>Verplicht veld</label>
                <select class="full-width select2 form-control" data-init-plugin="select2" name="fields_required[]" data-minimum-results-for-search="-1">
                  <option value="true">Ja</option>
                  <option value="false" selected>Nee</option>
                </select>
              </div>
              <div class="form-group form-group-default">
                <label>Toon in tabel</label>
                <select class="full-width select2 form-control" data-init-plugin="select2" name="fields_table[]" data-minimum-results-for-search="-1">
                  <option value="true">Ja</option>
                  <option value="false" selected>Nee</option>
                </select>
              </div>
              <hr>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <button class="btn btn-primary btn-lg" id="add_extra_field_btn"><i class="fa fa-plus"></i> Extra veld toevoegen</button>
          </div>
          <div class="col-lg-6">
            <button class="btn btn-warning btn-lg" id="remove_last_field_btn" style="display:none;"><i class="fa fa-minus"></i> Laatste veld verwijderen</button>
          </div>
        </div>
      </div>{{-- ffields-tab-ends --}}
      {{-- factions-tab-starts --}}
      <div class="col-sm-12 tab-pane fade" id="tab_resource_factions" role="tabpanel" aria-labelledby="factions-tab">
        <div class="row column-seperation">
          <div class="col-lg-12">
            <div class="form-group form-group-default required ">
              <label>Submissies opslaan in databank</label>
              <select class="full-width select2 form-control" data-init-plugin="select2" name="action_store" data-minimum-results-for-search="-1" required>
                <option value="true" selected>Ja</option>
                <option value="false">Nee</option>
              </select>
            </div>
            <hr>
            <div class="form-group form-group-default required ">
              <label>Detailpagina voor entries</label>
              <select class="full-width select2 form-control" data-init-plugin="select2" name="action_detail" data-minimum-results-for-search="-1" required>
                <option value="true">Ja</option>
                <option value="false" selected>Nee</option>
              </select>
            </div>
            <hr>
          </div>
        </div>
        <div class="submissions_container_wrapper" style="display:none;">
          <div class="row submissions_container_row">
            <div class="col-lg-12">
              <div class="form-group form-group-default required ">
                <label>Detailpagina URL</label>
                <input type="text" class="form-control" placeholder="Detailpagina URL" id="action_detail_url" name="action_detail_url" value=" ">
              </div>
              <div class="form-group form-group-default">
                <label>Pagina-type</label>
                <select class="full-width select2 form-control" data-init-plugin="select2" name="action_detail_page" data-minimum-results-for-search="-1">
                  @foreach($pageViews as $template => $page)
                    <optgroup label="Template: '{{ $template }}'">
                      @foreach($page['files'] as $file)
                        <option value="{{ $page['hintpath'] . '::templates.' . $template . '.' . $file }}" @if($loop->parent->first && $loop->first) selected @endif>{{ $file }} - {{ $template }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>{{-- factions-tab-ends --}}
    </div>
    <div class="row">
      <div class="col-sm-12">
        <p class="pull-right">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <button type="submit" name="create" class="btn btn-success btn-cons pull-right m-1" value="1">Opslaan</button>
          <a href="{{ route('dashboard.content.repeaters') }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
        </p>
      </div>
    </div>
  </form>
</div>
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