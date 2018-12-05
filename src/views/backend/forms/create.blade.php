@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.forms.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Maak een nieuw formulier
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
                        <input type="text" class="form-control" placeholder="Titel" id="form_title" name="form_title"  required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Slug</label>
                        <input type="text" class="form-control" placeholder="Slug" id="form_slug" name="form_slug" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Bestanden toegestaan</label>
                        <select class="full-width select2" data-init-plugin="select2" name="files_allowed" data-minimum-results-for-search="-1">
            							<option value="true">Ja</option>
            							<option value="false" selected>Nee</option>
            						</select>
                      </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="ffields">
              <div class="field_container_wrapper">
                <div class="row field_row_container">
                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-group-default required ">
                          <label>Veld Slug</label>
                          <input type="text" class="form-control" placeholder="Veld Slug" id="fields_slug" name="fields_slug[]" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-group-default required ">
                          <label>Veld Label</label>
                          <input type="text" class="form-control" placeholder="Veld Label" id="fields_label" name="fields_label[]" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-group-default required ">
                          <label>Veld Type</label>
                          <input type="text" class="form-control" placeholder="Veld Type" id="fields_type" name="fields_type[]" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-group-default required ">
                          <label>Veld Class</label>
                          <input type="text" class="form-control" placeholder="Veld Class" id="fields_class" name="fields_class[]" value="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-group-default ">
                          <label>Ouder Veld Class</label>
                          <input type="text" class="form-control" placeholder="Ouder Veld Class" id="fields_parentclass" name="fields_parentclass[]">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-group-default required ">
                          <label>Veld Placeholder</label>
                          <input type="text" class="form-control" placeholder="Veld Placeholder" id="fields_placeholder" name="fields_placeholder[]" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group form-group-default required ">
                          <label>Veld Validatie</label>
                          <input type="text" class="form-control" placeholder="Veld validatie" id="fields_validation" name="fields_validation[]" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group form-group-default ">
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
            </div>

            <div class="tab-pane fade" id="factions">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Submissies opslaan in databank</label>
                        <select class="full-width select2" data-init-plugin="select2" name="action_store" data-minimum-results-for-search="-1">
                          <option value="true" selected>Ja</option>
                          <option value="false">Nee</option>
                        </select>
                      </div>
                      <hr>
                      <div class="form-group form-group-default">
                        <label>Submissies verzenden</label>
                        <select class="full-width select2" data-init-plugin="select2" name="action_send" data-minimum-results-for-search="-1">
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
                          <label>Slug</label>
                          <input type="text" class="form-control" placeholder="slug" id="action_send_slug" name="action_send_slug[]">
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-group-default required ">
                              <label>E-mailadres geaddresseerde</label>
                              <input type="text" class="form-control" placeholder="E-mailadres Geaddresseerde" id="action_send_to" name="action_send_to[]">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-group-default required ">
                              <label>Naam geaddresseerde</label>
                              <input type="text" class="form-control" placeholder="Naam Geaddresseerde" id="action_send_to_name" name="action_send_to_name[]">
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-group-default required ">
                              <label>E-mailadres afzender</label>
                              <input type="text" class="form-control" placeholder="E-mailadres Afzender" id="action_send_from" name="action_send_from[]">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-group-default required ">
                              <label>Naam afzender</label>
                              <input type="text" class="form-control" placeholder="Naam Afzender" id="action_send_from_name" name="action_send_from_name[]">
                            </div>
                          </div>
                        </div>
                        
                        <div class="form-group form-group-default required ">
                          <label>Onderwerp</label>
                          <input type="text" class="form-control" placeholder="Onderwerp" id="action_send_subject" name="action_send_subject[]">
                        </div>
                        <div class="form-group form-group-default required ">
                          <label>Body</label>
                          <textarea id="meta_keywords" name="action_send_body[]" placeholder="Hier gaat je bericht in" style="min-height:210px!important;" class="form-control"></textarea>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Bestanden verzenden</label>
                          <select class="full-width select2" data-init-plugin="select2" name="action_send_files[]" data-minimum-results-for-search="-1">
                            <option value="true">Ja</option>
                            <option value="false" selected>Nee</option>
                          </select>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>E-mail template</label>
                          <select class="full-width select2" data-init-plugin="select2" name="action_send_template[]" data-minimum-results-for-search="-1">
                            @foreach($emailTemplates as $template => $emails)
                            <optgroup label="Template: '{{ $template }}'">
                              @foreach($emails['files'] as $file)
                                <option value="{{ $emails['hintpath'] . '::templates.' . $template . '.mails.' . $file }}">{{ $file }} - {{ $template }}</option>
                              @endforeach
                            </optgroup>
                            @endforeach
                          </select>
                        </div>
                        <hr>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <button class="btn btn-primary btn-lg" id="add_extra_action_btn" style="display:none;"><i class="fa fa-plus"></i> Extra actie toevoegen</button>
                </div>
                <div class="col-lg-6">
                  <button class="btn btn-warning btn-lg" id="remove_last_action_btn" style="display:none;"><i class="fa fa-minus"></i> Laatste actie verwijderen</button>
                </div>
              </div>

              <hr>
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Doorsturen naar (URL)</label>
                        <input type="text" class="form-control" placeholder="Hyperlink om naar door te sturen" id="action_redirect" name="action_redirect" required>
                      </div>
                </div>
              </div>

          </div>

          <div class="tab-pane fade" id="fbuttons">
              <div class="row">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Label</label>
                        <input type="text" class="form-control" placeholder="Label bv. Verzenden" id="button_label" name="button_label" required>
                      </div>
                      <div class="form-group form-group-default">
                        <label>Class</label>
                        <input type="text" class="form-control" placeholder="Class" id="button_class" name="button_class">
                      </div>
                      <div class="form-group form-group-default">
                        <label>ID</label>
                        <input type="text" class="form-control" placeholder="ID" id="button_id" name="button_id">
                      </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a href="{{ route('dashboard.forms') }}" class="pull-right"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
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

			$("#page_title").keyup(function(){
			    var text = $(this).val();
			    slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
			    $("#page_slug").val(slug_text);
          $("#page_slug_hidden").val(slug_text);    
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

      $('select[name=action_send]').change(function(){
        if($('select[name=action_send]').val() == 'true'){
          $('.submissions_container_wrapper').show();
          $('#add_extra_action_btn').show();
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