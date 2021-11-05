@extends('chuckcms::backend.layouts.base')

@section('content')
<div class="container p-3 min-height">
  <div class="row">
    <div class="col-sm-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mt-3">
          <li class="breadcrumb-item"><a href="{{ route('dashboard.content.resources') }}">Resources</a></li>
          <li class="breadcrumb-item active" aria-current="page">Maak een nieuwe resource</li>
        </ol>
      </nav>
    </div>
  </div>
  <form action="{{ route('dashboard.content.resources.save') }}" method="POST">
    <div class="row">
      <div class="col-sm-12">
        <div class="my-3">
          <ul class="nav nav-tabs justify-content-start" id="resourceTab" role="tablist">
              @foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue)
              <li class="nav-item" role="presentation">
                  <a class="nav-link{{ $loop->iteration == 1 ? ' active' : '' }}" id="{{ $langKey.'_page-tab' }}" data-target="#tab_resource_{{ $langKey }}" data-toggle="tab" href="#" role="tab" aria-controls="#{{ $langKey.'_page' }}" aria-selected="{{ $loop->iteration == 1 ? 'true' : 'false' }}">
                      <span>{{ $langValue['name'] }} ({{ strtoupper($langKey) }})</span>
                  </a>
              </li>
              @endforeach
          </ul>
          <div class="tab-content bg-light shadow-sm rounded p-3 mb-3 mx-1" id="resourceTabContent">
            @foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue)
              <div class="col-sm-12 tab-pane fade show @if($loop->iteration == 1) active @endif tab_page_wrapper" role="tabpanel" id="tab_resource_{{ $langKey }}">
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
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="my-3">
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right m-1" value="1">Opslaan</button>
            <a href="{{ route('dashboard.content.resources') }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
          </p>
        </div>
      </div>
    </div>
  </form>
</div>
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