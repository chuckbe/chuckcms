@extends('chuckcms::backend.layouts.base')

@section('content')
<!-- START CONTAINER -->
<div class="container p-3">
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.pages') }}">Pagina's</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bewerk Pagina</li>
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
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="css_page-tab" data-target="#tab_resource_css" data-toggle="tab" href="#" role="tab" aria-controls="#css_page" aria-selected="false">
                            <span>CSS</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="js_page-tab" data-target="#tab_resource_js" data-toggle="tab" href="#" role="tab" aria-controls="#js_page" aria-selected="false">
                            <span>JS</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content bg-light shadow-sm rounded p-3 mb-3 mx-1" id="pageTabContent">
                    
                    @foreach(ChuckSite::getSupportedLocales() as $langKey => $langValue)
                    <div class="col-sm-12 tab-pane fade show @if($loop->iteration == 1) active @endif tab_page_wrapper" role="tabpanel" id="tab_resource_{{ $langKey }}">
                        
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

                        <div class="form-group">
                            <label>Meta Titel *</label>
                            <input type="text" class="form-control meta_title meta_title_{{ $langKey }}" placeholder="Meta Titel" name="meta_title[{{ $langKey }}]" value="{{ $page->meta[$langKey]['title'] }}" data-lang="{{ $langKey }}" required>
                        </div>
                        <div class="form-group">
                            <label>Meta Beschrijving *</label>
                            <textarea name="meta_description[{{ $langKey }}]" placeholder="Meta Beschrijving" rows="2" class="form-control meta_description_{{ $langKey }} meta_description" data-lang="{{ $langKey }}" required>{{ $page->meta[$langKey]['description'] }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta Sleutelwoorden</label>
                            <textarea name="meta_keywords[{{ $langKey }}]" placeholder="Meta Sleutelwoorden" rows="2" class="form-control">{{ $page->meta[$langKey]['keywords'] }}</textarea>
                        </div>
                        <div class="form-group mb-1">
                            <label for="meta_robots_index[{{ $langKey }}]">
                                <input type="hidden" name="meta_robots_index[{{ $langKey }}]" value="0">
                                <input type="checkbox" name="meta_robots_index[{{ $langKey }}]" id="meta_robots_index[{{ $langKey }}]" value="1" @if(!(strpos($page->meta[$langKey]['robots'], 'noindex') !== false)) checked @endif/>
                                Meta Robots Indexeren
                            </label>
                            
                        </div>
                        <div class="form-group">
                            <label for="meta_robots_follow[{{ $langKey }}]">
                                <input type="hidden" name="meta_robots_follow[{{ $langKey }}]" value="0">
                                <input type="checkbox" name="meta_robots_follow[{{ $langKey }}]" id="meta_robots_follow[{{ $langKey }}]" value="1" @if(!(strpos($page->meta[$langKey]['robots'], 'nofollow') !== false)) checked @endif/>
                                Meta Robots Volgen
                            </label>
                        </div>
                        <hr>

                        <div class="meta_field_wrapper" data-lang="{{ $langKey }}">
                            @php
                            $metaLoop = 0;
                            @endphp
                            @foreach($page->meta[$langKey] as $mKey => $mValue)
                            @if(!in_array($mKey, ['title', 'description', 'keywords', 'og:url', 'og:type', 'og:title', 'og:description', 'og:site_name', 'og:image', 'robots', 'googlebots', 'og-url', 'og-type', 'og-title', 'og-description', 'og-site_name']))
                            <div class="row meta_field_row" data-order="{{ $loop->iteration }}">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Meta Key</label>
                                        <input type="text" class="form-control meta_key" placeholder="key" id="meta_key" name="meta_key[{{ $langKey }}][]" data-order="{{ $loop->iteration }}" value="{{ $mKey }}">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Meta Waarde</label>
                                        <input type="text" class="form-control meta_value @if($mKey == 'title') meta_title @endif  @if($mKey == 'description') meta_description @endif" placeholder="waarde" id="meta_value" name="meta_value[{{ $langKey }}][]" data-order="{{ $loop->iteration }}" value="{{ $mValue }}" data-lang="{{ $langKey }}">
                                    </div>
                                </div>
                            </div>
                            @php
                            $metaLoop++;
                            @endphp
                            @endif
                            @endforeach
                            @if($metaLoop == 0)
                            <div class="row meta_field_row" data-order="1">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Meta Key</label>
                                        <input type="text" class="form-control meta_key" placeholder="key" id="meta_key" name="meta_key[{{ $langKey }}][]" data-order="1">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-8">
                                    <div class="form-group">
                                        <label>Meta Waarde</label>
                                        <input type="text" class="form-control meta_value" placeholder="waarde" id="meta_value" name="meta_value[{{ $langKey }}][]" data-order="1">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-12 text-right text-end">
                                <button type="button" class="btn btn-sm btn-danger mr-2 remove_meta_field_btn" style="display:none;">-</button>
                                <button type="button" class="btn btn-sm btn-success add_meta_field_btn">+</button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-sm-12 tab-pane fade show tab_page_wrapper" role="tabpanel" id="tab_resource_css">
                        <div class="form-group" style="position:relative;height:500px;">
                            <div id="ace_css_editor" style="position: absolute;width: 100%;height: 500px;">{{ $page->css }}</div>
                            <textarea name="css" style="display: none;">{{ $page->css }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-12 tab-pane fade show tab_page_wrapper" role="tabpanel" id="tab_resource_js">
                        <div class="form-group" style="position:relative;height:500px;">
                            <div id="ace_js_editor" style="position: absolute;width: 100%;height: 500px;">{{ $page->js }}</div>
                            <textarea name="js" style="display: none;">{{ $page->js }}</textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="col-sm-12 tab-pane fade show active">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>OpenGraph Afbeelding (1200 x 630 pixels)</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                          <a id="ogImage" data-input="ogImageInput" data-preview="ogImageHolder" class="btn btn-primary" style="color:#FFF">
                                            <i class="fa fa-picture-o"></i> Kies
                                          </a>
                                        </span>
                                        <input id="ogImageInput" class="form-control" type="text" name="meta_image" value="{{ array_key_exists('og:image', $page->meta[ChuckSite::getFeaturedLocale()]) && !is_null($page->meta[ChuckSite::getFeaturedLocale()]['og:image']) ? $page->meta[ChuckSite::getFeaturedLocale()]['og:image'] : '' }}">
                                    </div>
                                    <img id="ogImageHolder" src="{{ array_key_exists('og:image', $page->meta[ChuckSite::getFeaturedLocale()]) && !is_null($page->meta[ChuckSite::getFeaturedLocale()]['og:image']) ? ChuckSite::getSite('domain').'/'.$page->meta[ChuckSite::getFeaturedLocale()]['og:image'] : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' }}" style="margin-top:15px;max-height:100px;">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Template</label>
                                   <select class="form-control mt-2" name="template_id">
                                        @foreach($templates as $tmpl)
                                        <option value="{{ $tmpl->id }}" @if($tmpl->id == $page->template_id) selected @endif>{{ $tmpl->name }} (v{{ $tmpl->version }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- col-md-4 ends --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Actief</label>
                                    <select class="form-control mt-2" name="active" required>
                                        <option value="1" @if($page->active == 1) selected @endif>Actief</option>
                                        <option value="0" @if($page->active == 0) selected @endif>Concept</option>
                                    </select>
                                </div>
                            </div>
                            {{-- col-md-3 ends --}}
                            <div class="col-md-4">
                                <div class="form-group w-100">
                                    <label>Pagina</label>
                                    <select class="form-control mt-2" name="page">
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
                            {{-- col-md-8 ends --}}
                            <div class="col-sm-12">
                                <div class="form-group form-group-default input-group ">
                                    <label for="isHp">
                                        <input type="hidden" name="isHp" value="0">
                                        <input type="checkbox" value="1" name="isHp" id="isHp" @if($page->isHp == 1) checked="checked" @endif />
                                        Is dit de homepage?
                                    </label>
                                </div>
                            </div>
                            {{-- col-md-4 ends --}}           
                        </div>

                        <div class="row column-seperation">
                            <div class="col-lg-12">
                                <div class="form-group form-group-default required ">
                                    <label>Pagina beperkt tot volgende gebruikersrollen</label><br/>
                                    <select class="form-control mt-2" multiple name="roles[]">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if( in_array($role->id, explode('|', $page->roles)) ) selected @endif> {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
              
                    </div>
        </div>
      </div>
    </div>
  </div>{{-- row ends here --}}
  <div class="row">
    <div class="col-sm-12">
      <div class="my-3">
        <p class="pull-right">
          <input type="hidden" name="page_id" value="{{ $page->id }}">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <button type="submit" name="update" class="btn btn-success btn-cons pull-right m-1" value="1">Opslaan</button>
          <a href="{{ route('dashboard.pages') }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
        </p>
      </div>
    </div>
  </div>
  </form>
</div>
<!-- END CONTAINER  -->


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

    .ace_editor_height_null{height:0px;visibility:hidden;}
    .ace_editor_height_full{height:500px;visibility: visible;}
  </style>
@endsection

@section('scripts')
<script src="https://cdn.chuck.be/assets/plugins/ace/ace.js"></script>
<script src="{{ URL::to('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
$( document ).ready(function() { 
    var css_editor = ace.edit('ace_css_editor');
    css_editor.setTheme("ace/theme/monokai");
    css_editor.session.setMode("ace/mode/css");

    var css_textarea = $('textarea[name="css"]');
    css_editor.getSession().on("change", function () {
        css_textarea.val(css_editor.getSession().getValue());
    });

    var js_editor = ace.edit('ace_js_editor');
    js_editor.setTheme("ace/theme/monokai");
    js_editor.session.setMode("ace/mode/javascript");

    var js_textarea = $('textarea[name="js"]');
    js_editor.getSession().on("change", function () {
        js_textarea.val(js_editor.getSession().getValue());
    });

    $(".select2").select2();

    var domain = "{{ URL::to('dashboard/media')}}";
    $('#ogImage').filemanager('image', {prefix: domain});

    if( $('.meta_field_row').length > 1){
        $('.remove_meta_field_btn').show();
    }

    $('body').on('keyup', '.meta_key', function (event) {
        var text = $(this).val();
        var iOrder = $(this).attr('data-order');
        slug_text = text.toLowerCase()
            .replace(/\\+/g,'')
            .replace(/\(+/g,'')
            .replace(/\)+/g,'')
            .replace(/\{+/g,'')
            .replace(/\}+/g,'')
            .replace(/\“+/g,'')
            .replace(/"+/g,'');

        $(".meta_key[data-order="+iOrder+"]").val(slug_text);
    });

    $('body').on('click', '.add_meta_field_btn', function (event) {
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
    });

    $('body').on('click', '.remove_meta_field_btn', function (event) {
        $('.meta_field_wrapper').each(function() {
            if($( this ).find('.meta_field_row').length > 1){
                $( this ).find('.meta_field_row:last').remove();
                if($( this ).find('.meta_field_row').length == 1){
                    $('.remove_meta_field_btn').hide();
                }
            }
        });
    });

    $('body').on('keyup', '.page_title', function (event) {
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

    $('body').on('keyup', '.page_slug', function (event) {
        var text = $(this).val();
        var lang = $(this).attr('data-lang');
        var url_path = $(this).attr('data-url');
        slug_text = text.toLowerCase().replace(/ +/g,'-');
        $('.page_slug_hidden_'+lang).val(slug_text);
        $('.serp_url_'+lang).text(url_path+'/'+slug_text);
    });

    $('body').on('keyup', '.meta_title', function (event) {
        var text = $(this).val();
        var lang = $(this).attr('data-lang');
        $('.serp_title_'+lang).text(text);
    });

    $('body').on('keyup', '.meta_description', function (event) {
        var text = $(this).val();
        var lang = $(this).attr('data-lang');
        $('.serp_desc_'+lang).text(text);
    });

});
</script>
@endsection