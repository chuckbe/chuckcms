@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.templates.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Bewerk template
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
              <a href="#" data-toggle="tab" data-target="#ffields"><span>CSS</span></a>
            </li>
            <li class="nav-item">
              <a href="#" data-toggle="tab" data-target="#factions"><span>JS</span></a>
            </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="fsettings">
              <div class="row column-seperation">
                <div class="col-lg-12">
                      <div class="form-group form-group-default required ">
                        <label>Naam</label>
                        <input type="text" class="form-control" placeholder="Naam" id="form_title" name="template_name" value="{{ $template->name }}" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Slug</label>
                        <input type="text" class="form-control" placeholder="Slug" id="form_slug" name="template_slug" value="{{ $template->slug }}" required disabled>
                        <input type="hidden" class="form-control" placeholder="Slug" id="form_slug" name="template_slug" value="{{ $template->slug }}" required>
                      </div>
                      <div class="form-group form-group-default required ">
                        <label>Fonts</label>
                        <input type="text" class="form-control" placeholder="Fonts" name="template_fonts" value="{{ $template->fonts['raw'] }}" required>
                      </div>
                </div>
              </div>
              @if(count($template->json) > 0)
              <hr>
              <div class="row column-seperation">
                <div class="col-lg-12">
                    @foreach($template->json as $key => $setting)
                      <div class="form-group form-group-default required ">
                        <label>{{ $setting['label'] }}</label>
                        @if($setting['type'] == 'text')
                        <input type="text" class="form-control" placeholder="{{ $setting['label'] }}" id="form_title" name="json_slug[{{ $key }}]" value="{{ $setting['value'] }}">
                        @elseif($setting['type'] == 'textarea')
                        <input type="text" class="form-control" placeholder="{{ $setting['label'] }}" id="form_title" name="json_slug[{{ $key }}]" value="{{ $setting['value'] }}">
                        @endif
                      </div>
                    @endforeach

                </div>
              </div>
              @endif
            </div>

            <div class="tab-pane fade" id="ffields">
              <div class="field_container_wrapper">
              @foreach($template->css as $cssKey => $cssValue)
              <div class="row field-input-group field_row_container">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>CSS Slug</label>
                        <input type="text" class="form-control" placeholder="CSS Slug" name="css_slug[]" value="{{ $cssKey }}" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group form-group-default required ">
                        <label>CSS File</label>
                        <input type="text" class="form-control" placeholder="File" name="css_href[]" value="{{ $cssValue['href'] }}" required>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group form-group-default input-group">
                        <div class="form-input-group">
                          <label class="inline">Lokaal bestand?</label>
                        </div>
                        <div class="input-group-addon bg-transparent h-c-50">
                          <input type="hidden" name="css_asset[{{ $loop->index }}]" value="0">
                          <input type="checkbox" data-init-plugin="switchery" data-size="small" data-color="primary" value="1" name="css_asset[{{ $loop->index }}]" @if($cssValue['asset'] == 'true') checked @endif />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <button class="btn btn-primary btn-lg" type="button" id="add_extra_field_btn"><i class="fa fa-plus"></i> Extra veld toevoegen</button>
                </div>
                <div class="col-lg-6">
                  <button class="btn btn-warning btn-lg" type="button" id="remove_last_field_btn" @if(count($template->css) == 1) style="display:none;" @endif><i class="fa fa-minus"></i> Laatste veld verwijderen</button>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="factions">
              <div class="js_field_container_wrapper">
              @foreach($template->js as $jsKey => $jsValue)
              <div class="row field-input-group js_field_row_container">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>JS Slug</label>
                        <input type="text" class="form-control" placeholder="JS Slug" name="js_slug[]" value="{{ $jsKey }}" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group form-group-default required ">
                        <label>JS File</label>
                        <input type="text" class="form-control" placeholder="File" name="js_href[]" value="{{ $jsValue['href'] }}" required>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group form-group-default input-group">
                        <div class="form-input-group">
                          <label class="inline">Lokaal bestand?</label>
                        </div>
                        <div class="input-group-addon bg-transparent h-c-50">
                          <input type="hidden" name="js_asset[{{ $loop->index }}]" value="0">
                          <input type="checkbox" data-init-plugin="switchery" data-size="small" data-color="primary" value="1" name="js_asset[{{ $loop->index }}]" @if($jsValue['asset'] == 'true') checked @endif />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <button class="btn btn-primary btn-lg" type="button" id="add_extra_jsfield_btn"><i class="fa fa-plus"></i> Extra veld toevoegen</button>
                </div>
                <div class="col-lg-6">
                  <button class="btn btn-warning btn-lg" type="button" id="remove_last_jsfield_btn" @if(count($template->js) == 1) style="display:none;" @endif><i class="fa fa-minus"></i> Laatste veld verwijderen</button>
                </div>
              </div>
            </div>

          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <input type="hidden" name="template_id" value="{{ $template->id }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a href="{{ route('dashboard.templates') }}" class="pull-right"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
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

      $('#add_extra_jsfield_btn').click(function(){
        destroySelect2();
        $('.js_field_row_container:first').clone().appendTo('.js_field_container_wrapper');
        if($('.js_field_row_container').length > 1){
          $('#remove_last_jsfield_btn').show();
        }
        initSelect2();
      });

      $('#remove_last_jsfield_btn').click(function(){
        if($('.js_field_row_container').length > 1){
          $('.js_field_row_container:last').remove();
          if($('.js_field_row_container').length == 1){
            $('#remove_last_jsfield_btn').hide();
          }
        }
      });

		});
	</script>
@endsection