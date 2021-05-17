@extends('chuckcms::backend.layouts.base')

@section('content')
<!-- START CONTAINER -->
<div class="container p-3 min-height">
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.pages') }}">Pagina's</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Maak een nieuw Pagina</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('dashboard.page.save') }}" method="POST">
    <div class="row">
        <div class="col-sm-12">
            <div class="my-3">
                <ul class="nav nav-tabs justify-content-start" id="pageTab" role="tablist">
                    @foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link{{ $loop->iteration == 1 ? ' active' : '' }}" id="{{ $langKey.'_page-tab' }}" data-target="#tab_resource_{{ $langKey }}" data-toggle="tab" href="#" role="tab" aria-controls="#{{ $langKey.'_page' }}" aria-selected="{{ $loop->iteration == 1 ? 'true' : 'false' }}">
                            <span>{{ $langValue['name'] }} ({{ strtoupper($langKey) }})</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
          
                <div class="tab-content bg-light shadow-sm rounded p-3 mb-3 mx-1" id="pageTabContent">
                    @foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue)
                    <div class="col-sm-12 tab-pane fade show{{ $loop->iteration == 1 ? ' active' : '' }} tab_page_wrapper" role="tabpanel" id="tab_resource_{{ $langKey }}">
                        <div class="form-group">
                            <label>Titel *</label>
                            <input type="text" class="form-control page_title" placeholder="Titel" name="page_title[{{ $langKey }}]" data-lang="{{ $langKey }}" data-url="http://package.local" required>
                        </div>
                        <div class="form-group">
                            <label>Slug *</label>
                            <input type="text" class="form-control page_slug page_slug_{{ $langKey }}" placeholder="Titel" name="slug[{{ $langKey }}]" data-lang="{{ $langKey }}" data-url="{{ ChuckSite::getSetting('domain') }}" required>
                            <input type="hidden" class="form-control page_slug_hidden_{{ $langKey }}" name="page_slug[{{ $langKey }}]">
                        </div>

                        <hr>
                        <div class="serp-preview">
                            <a class="serp-title serp_title_{{ $langKey }}" href="/">[title]</a><br>
                            <a class="serp-url serp_url_{{ $langKey }}" href="/">[url]</a><br>
                            <p class="serp-desc serp_desc_{{ $langKey }}">[description]</p>
                        </div>
                        <hr>
                        
                        <div class="form-group">
                            <label>Meta Titel *</label>
                            <input type="text" class="form-control meta_title meta_title_{{ $langKey }}" placeholder="Meta Titel" name="meta_title[{{ $langKey }}]" data-lang="{{ $langKey }}" required>
                        </div>
                        <div class="form-group">
                            <label>Meta Beschrijving *</label>
                            <textarea name="meta_description[{{ $langKey }}]" placeholder="Meta Beschrijving" rows="2" class="form-control meta_description_{{ $langKey }} meta_description" data-lang="{{ $langKey }}" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta Sleutelwoorden *</label>
                            <textarea name="meta_keywords[{{ $langKey }}]" placeholder="Meta Sleutelwoorden" rows="2" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="meta_robots_index[{{ $langKey }}]">
                                <input type="hidden" name="meta_robots_index[{{ $langKey }}]" value="0">
                                <input type="checkbox" name="meta_robots_index[{{ $langKey }}]" id="meta_robots_index[{{ $langKey }}]" value="1" checked/>
                                Meta Robots Indexeren
                            </label>
                            
                        </div>
                        <div class="form-group">
                            <label for="meta_robots_follow[{{ $langKey }}]">
                                <input type="hidden" name="meta_robots_follow[{{ $langKey }}]" value="0">
                                <input type="checkbox" name="meta_robots_follow[{{ $langKey }}]" id="meta_robots_follow[{{ $langKey }}]" value="1" checked/>
                                Meta Robots Volgen
                            </label>
                        </div>
                        <hr>
                        <div class="meta_field_wrapper" data-lang="{{ $langKey }}">
                            <div class="row meta_field_row" data-order="1">
                                <div class="col-lg-4">
                                    <div class="form-group form-group-default ">
                                        <label>Meta Key</label>
                                        <input type="text" class="form-control meta_key" placeholder="key" id="meta_key" name="meta_key[{{ $langKey }}][]" data-order="1">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group form-group-default ">
                                        <label>Meta Waarde</label>
                                        <input type="text" class="form-control meta_value" placeholder="waarde" id="meta_value" name="meta_value[{{ $langKey }}][]" data-order="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-primary add_meta_field_btn">+ Toevoegen</button>
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-warning remove_meta_field_btn" style="display:none;">- Verwijderen</button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-sm-12 tab-pane fade show active" id="fade1">
                        <div class="row column-separation">
                            <div class="col-lg-12">
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default required ">
                                            <label>Template</label>
                                            <select class="form-control mt-2" name="template_id" data-minimum-results-for-search="-1">
                                              @foreach($templates as $tmpl)
                                                <option value="{{ $tmpl->id }}">{{ $tmpl->name }} (v{{ $tmpl->version }})</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Actief</label><br>
                                            <select class="form-control mt-2" name="active" required>
                                                <option value="1" selected>Actief</option>
                                                <option value="0" >Concept</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default required ">
                                            <label>Pagina</label><br>
                                            <select class="form-control mt-2" name="page" required>
                                                <option value="">Standaard</option>
                                                @foreach($pageViews as $template => $view)
                                                <optgroup label="Template: '{{ $template }}'">
                                                    @foreach($view['files'] as $file)
                                                    <option value="{{ $view['hintpath'] . '::templates.' . $template . '.' . $file }}">{{ $file }} - {{ $template }}</option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mt-3">
                                        <div class="form-group">
                                            <label for="isHp">
                                                <input type="hidden" name="isHp" value="0">
                                                <input type="checkbox" name="isHp" id="isHp" value="1" />
                                                Is dit de homepage?
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
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
            <a href="{{ route('dashboard.pages') }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
          </p>
        </div>
      </div>
    </div>
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
    $(".select2").select2();
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