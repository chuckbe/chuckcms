@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.page.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Bewerk pagina "{{ $page->title }}"
    </div>
  </div>
  <div class="card-block">
    <div class="row">
      <div class="col-md-12">
		{{-- <h5>Fade effect</h5> Add the class
        <code>fade</code> to the tab panes
        <br>
        <br> --}}
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
            <div class="tab-pane fade show @if($loop->iteration == 1) active @endif tab_page_wrapper" id="tab_resource_{{ $langKey }}">
              <h4>{{ $langValue['name'] }}</h4>
              <div class="row column-seperation">
                <div class="col-lg-12">
                  <div class="form-group form-group-default required ">
                    <label>Titel</label>
                    <input type="text" class="form-control page_title page_title_{{ $langKey }}" placeholder="Titel" id="page_title" name="page_title[{{ $langKey }}]" value="{{ $page->getTranslation('title', $langKey) }}" data-lang="{{ $langKey }}" required>
                  </div>
                  <div class="form-group form-group-default required ">
                    <label>Slug</label>
                    <input type="text" class="form-control page_slug page_slug_{{ $langKey }}" placeholder="Slug" id="page_slug" name="slug[{{ $langKey }}]" data-lang="{{ $langKey }}" data-url="{{ ChuckSite::getSetting('domain') }}" value="{{ $page->getTranslation('slug', $langKey) }}" required>
                    <input type="hidden" class="form-control page_slug_hidden_{{ $langKey }}" id="page_slug_hidden" name="page_slug[{{ $langKey }}]" value="{{ $page->getTranslation('slug', $langKey) }}">
                  </div>
                  <hr>
                  <div class="serp-preview">
                      <a class="serp-title serp_title_{{ $langKey }}" href="/">{{ $page->getTranslation('title', $langKey) }}</a><br>
                      <a class="serp-url serp_url_{{ $langKey }}" href="/">{{ ChuckSite::getSetting('domain') }}/{{ $page->getTranslation('slug', $langKey) }}</a><br>
                      <p class="serp-desc serp_desc_{{ $langKey }}">{{ $page->meta[$langKey]['description'] }}</p>
                  </div>
                  <hr>
                  <div class="meta_field_wrapper" data-lang="{{ $langKey }}">
                    @foreach($page->meta[$langKey] as $mKey => $mValue)
                    <div class="row meta_field_row" data-order="{{ $loop->iteration }}">
                      <div class="col-lg-4">
                        <div class="form-group form-group-default required ">
                          <label>Meta Key</label>
                          <input type="text" class="form-control meta_key" placeholder="key" id="meta_key" name="meta_key[{{ $langKey }}][]" data-order="{{ $loop->iteration }}" value="{{ $mKey }}" required>
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group form-group-default required ">
                          <label>Meta Waarde</label>
                          <input type="text" class="form-control meta_value @if($mKey == 'title') meta_title @endif  @if($mKey == 'description') meta_description @endif" placeholder="waarde" id="meta_value" name="meta_value[{{ $langKey }}][]" data-order="{{ $loop->iteration }}" value="{{ $mValue }}" data-lang="{{ $langKey }}" required>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>

                  <hr>
                  <div class="row">
                    <div class="col-lg-6">
                      <button type="button" class="btn btn-primary add_meta_field_btn" id="add_meta_field_btn">+ Toevoegen</button>
                    </div>
                    <div class="col-lg-6">
                      <button type="button" class="btn btn-warning remove_meta_field_btn" id="remove_meta_field_btn" style="display:none;">- Verwijderen</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            <hr>
            <div class="tab-pane fade show active">
              <div class="row column-separation">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-default required ">
                        <label>Template</label>
                        <select class="full-width" data-init-plugin="select2" name="template_id" data-minimum-results-for-search="-1">
                          @foreach($templates as $tmpl)
                            <option value="{{ $tmpl->id }}" @if($tmpl->id == $page->template_id) selected @endif>{{ $tmpl->name }} (v{{ $tmpl->version }})</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group form-group-default required ">
                        <label>Actief</label>
                        <select class="full-width" data-init-plugin="select2" name="active" data-minimum-results-for-search="-1">
                          <option value="1" @if($page->active == 1) selected @endif>Actief</option>
                          <option value="0" @if($page->active == 0) selected @endif>Concept</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group form-group-default required ">
                        <label>Pagina</label>
                        <select class="full-width" data-init-plugin="select2" name="page" data-minimum-results-for-search="-1">
                          <option value="">Standaard</option>
                          @foreach($pageViews as $template => $view)
                          <optgroup label="Template: '{{ $template }}'">
                            @foreach($view['files'] as $file)
                              <option value="{{ $view['hintpath'] . '::templates.' . $template . '.' . $file }}" @if($page->page !== null) @if($page->page == $view['hintpath'] . '::templates.' . $template . '.' . $file) selected @endif @endif>{{ $file }} - {{ $template }}</option>
                            @endforeach
                          </optgroup>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group form-group-default input-group">
                        <div class="form-input-group">
                          <label class="inline">Homepage</label>
                        </div>
                        <div class="input-group-addon bg-transparent h-c-50">
                          <input type="hidden" name="isHp" value="0">
                          <input type="checkbox" data-init-plugin="switchery" data-size="small" data-color="primary" value="1" name="isHp" @if($page->isHp == 1) checked="checked" @endif />
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>

            
          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="page_id" value="{{ $page->id }}">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" name="update" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a href="{{ route('dashboard.pages') }}" class="pull-right"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
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
	<style>
  .serp-preview {
    font-family: arial, sans-serif  !important;
    line-height: 15px !important;
    font-size: 13px !important;
    font-style: normal  !important;
    width: 540px !important;
    clear: both  !important;
    /* codepen styling */
    margin: 40px 15px !important
  }

  .serp-preview .serp-title {
    color: #11c !important;
    font-size: 18px !important;
    line-height: 24px !important;
    text-decoration: none !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    margin-bottom: 2px !important;
  }

  .serp-preview .serp-url {
    font-size: 15px !important;
    color: #282 !important;
    line-height: 18px !important;
    text-decoration: none !important;
  }

  .serp-preview .serp-desc {
    font-size: 15px !important;
    color: #000 !important;
    line-height: 20px !important;
  }
  </style>
@endsection

@section('scripts')
	<script>
    $( document ).ready(function() { 
    init(); 

    if( $('.meta_field_row').length > 1){
      $('.remove_meta_field_btn').show();
    }

    function init() {
      $(".resource_slug_input").keyup(function(){
          var text = $(this).val();
          slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'');
          $(".resource_slug_input").val(slug_text);   
      });

      $(".meta_key").keyup(function(){
          console.log('This is the index of the element : ',$('.meta_field_row').index($(this)));
          var text = $(this).val();
          var iOrder = $(this).attr('data-order');
          slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'');
          $(".meta_key[data-order="+iOrder+"]").val(slug_text);   
          
      });

      
    }
      $('.add_meta_field_btn').click(function(){
        $('.meta_field_row:first').clone().appendTo('.meta_field_wrapper');

        $('.meta_field_wrapper').each(function() {
          var lang = $(this).attr('data-lang');
          var order = $(this).find('.meta_field_row').attr('data-order') + 1;

          $( this ).find('#meta_key').attr('name', 'meta_key[' + lang + '][]');
          $( this ).find('#meta_value').attr('name', 'meta_value[' + lang + '][]');

          $( this ).find('.meta_field_row').attr('data-order', order);
          $( this ).find('.meta_key:last').attr('data-order', order);
          $( this ).find('.meta_value:last').attr('data-order', order);
          
        });

        if( $('.meta_field_row').length > 1){
          $('.remove_meta_field_btn').show();
        }

        init();
      });



      $('.remove_meta_field_btn').click(function(){
        
        $('.meta_field_wrapper').each(function() {
          
          if($( this ).find('.meta_field_row').length > 1){
            
            $( this ).find('.meta_field_row:last').remove();
            if($( this ).find('.meta_field_row').length == 1){
              $('.remove_meta_field_btn').hide();
            }
          }

        });

      });

      $('.tab_page_wrapper').each(function() {
        $('.page_title').keyup(function(){
            var text = $(this).val();
            var lang = $(this).attr('data-lang');
            var url_path = $(this).attr('data-url');
            slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            $('.page_slug_'+lang).val(slug_text);
            $('.page_slug_hidden_'+lang).val(slug_text);
            $('.meta_title_'+lang).val(text).change();
            $('.serp_title_'+lang).text(text); 
            $('.serp_url_'+lang).text(url_path+'/'+slug_text);
        });

        $('.page_slug').keyup(function(){
            var text = $(this).val();
            var lang = $(this).attr('data-lang');
            var url_path = $(this).attr('data-url');
            slug_text = text.toLowerCase().replace(/ +/g,'-');
            $('.page_slug_hidden_'+lang).val(slug_text);
            $('.serp_url_'+lang).text(url_path+'/'+slug_text);
        });

        $('.meta_title').keyup(function(){
            var text = $(this).val();
            var lang = $(this).attr('data-lang');
            $('.serp_title_'+lang).text(text);
        });

        $('.meta_description').keyup(function(){
            var text = $(this).val();
            var lang = $(this).attr('data-lang');
            $('.serp_desc_'+lang).text(text);
        });
      });

    });
  </script>
@endsection