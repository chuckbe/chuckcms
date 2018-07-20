@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.content.resources.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Maak een nieuwe resource
    </div>
  </div>
  <div class="card-block">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-transparent">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-tabs-linetriangle" data-init-reponsive-tabs="dropdownfx">
            @foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue)
              <li class="nav-item">
                <a href="#" @if($loop->iteration == 1) class="active" @endif data-toggle="tab" data-target="#tab_resource_{{ $langKey }}"><span>{{ $langValue['name'] }} ({{ $langValue['native'] }})</span></a>
              </li>
            @endforeach
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">

            @foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue)
            <div class="tab-pane fade show @if($loop->iteration == 1) active @endif" id="tab_resource_{{ $langKey }}">
              <h4>{{ $langValue['name'] }}</h4>
              <div class="row column-seperation">
                <div class="col-lg-12">
                  <div class="form-group form-group-default required ">
                    <label>Slug</label>
                    <input type="text" class="form-control resource_slug_input" placeholder="slug" id="resource_slug" name="slug[]" required>
                  </div>
                  <hr>

                  <div class="resource_field_wrapper" data-lang="{{ $langKey }}">
                    <div class="row resource_field_row" data-order="1">
                      <div class="col-lg-4">
                        <div class="form-group form-group-default required ">
                          <label>Veld Key</label>
                          <input type="text" class="form-control resource_key" placeholder="key" id="resource_key" name="resource_key[{{ $langKey }}][]" data-order="1" required>
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group form-group-default required ">
                          <label>Veld Waarde</label>
                          <input type="text" class="form-control resource_value" placeholder="waarde" id="resource_value" name="resource_value[{{ $langKey }}][]" data-order="1" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <hr>
                  <div class="row">
                    <div class="col-lg-6">
                      <button type="button" class="btn btn-primary add_resource_field_btn" id="add_resource_field_btn">+ Toevoegen</button>
                    </div>
                    <div class="col-lg-6">
                      <button type="button" class="btn btn-warning remove_resource_field_btn" id="remove_resource_field_btn" style="display:none;">- Verwijderen</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach

          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a href="{{ route('dashboard.content.resources') }}" class="pull-right"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
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
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script>
		$( document ).ready(function() { 
    init(); 


    function init() {
			$(".resource_slug_input").keyup(function(){
			    var text = $(this).val();
			    slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'');
			    $(".resource_slug_input").val(slug_text);   
			});

      $(".resource_key").keyup(function(){
          console.log('This is the index of the element : ',$('.resource_field_row').index($(this)));
          var text = $(this).val();
          var iOrder = $(this).attr('data-order');
          slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'');
          $(".resource_key[data-order="+iOrder+"]").val(slug_text);   
          
      });
    }
			$('.add_resource_field_btn').click(function(){
        $('.resource_field_row:first').clone().appendTo('.resource_field_wrapper');

        $('.resource_field_wrapper').each(function() {
          var lang = $(this).attr('data-lang');
          var order = $(this).find('.resource_field_row').attr('data-order') + 1;

          $( this ).find('#resource_key').attr('name', 'resource_key[' + lang + '][]');
          $( this ).find('#resource_value').attr('name', 'resource_value[' + lang + '][]');

          $( this ).find('.resource_field_row').attr('data-order', order);
          $( this ).find('.resource_key:last').attr('data-order', order);
          $( this ).find('.resource_value:last').attr('data-order', order);
          
        });

        if( $('.resource_field_row').length > 1){
          $('.remove_resource_field_btn').show();
        }

        init();
      });

      $('.remove_resource_field_btn').click(function(){
        
        $('.resource_field_wrapper').each(function() {
          
          if($( this ).find('.resource_field_row').length > 1){
            
            $( this ).find('.resource_field_row:last').remove();
            if($( this ).find('.resource_field_row').length == 1){
              $('.remove_resource_field_btn').hide();
            }
          }

        });

      });

      

		});
	</script>
@endsection