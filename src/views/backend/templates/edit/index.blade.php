@extends('chuckcms::backend.layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.templates') }}">Templates</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $template->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="my-3">
                <ul class="nav nav-tabs justify-content-start" id="pageTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="home" aria-selected="true">Algemeen</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="css-tab" data-toggle="tab" href="#css" role="tab" aria-controls="css" aria-selected="false">CSS</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="js-tab" data-toggle="tab" href="#js" role="tab" aria-controls="js" aria-selected="false">JS</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form action="{{ route('dashboard.templates.save') }}" method="POST">
        <div class="row tab-content bg-light shadow-sm rounded p-3 mb-3 mx-1" id="pageTabContent">
            <div class="col-sm-12 tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                
                <div class="form-group row required">
                    <label for="template_name" class="col-sm-2 col-form-label">Naam *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Naam" id="template_name" name="template_name" value="{{ $template->name }}" required>
                    </div>
                </div>
                <div class="form-group row required">
                    <label for="template_name" class="col-sm-2 col-form-label">Slug *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Slug" id="template_slug" name="template_slug" value="{{ $template->slug }}" required disabled>
                    </div>
                </div>
                <div class="form-group row required">
                    <label for="template_name" class="col-sm-2 col-form-label">Fonts *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Fonts" id="template_fonts" name="template_fonts" value="{{ array_key_exists('raw', $template->fonts) ? $template->fonts['raw'] : null }}" required>
                    </div>
                </div>

                @if(count($template->json) > 0)
                <hr>
                @foreach($template->json as $key => $setting)
                <div class="form-group required">
                    <label for="{{ $key }}">{{ $setting['label'] }}</label>
                    @if($setting['type'] == 'text')
                    <input type="text" class="form-control" placeholder="{{ $setting['label'] }}" id="{{ $key }}" name="json_slug[{{ $key }}]" value="{{ $setting['value'] }}">
                    @elseif($setting['type'] == 'textarea')
                    <input type="text" class="form-control" placeholder="{{ $setting['label'] }}" id="{{ $key }}" name="json_slug[{{ $key }}]" value="{{ $setting['value'] }}">
                    @endif
                </div>
                @endforeach
                @endif
            </div>


            <div class="col-sm-12 tab-pane fade" id="css" role="tabpanel" aria-labelledby="css-tab">
                <div class="form-group row">
                    <div class="col-6 col-sm-3 order-1">
                        <small>Slug *</small>
                    </div>
                    <div class="col-12 col-sm-6 order-3 order-sm-2">
                        <small>URL *</small>
                    </div>
                    <div class="col-6 col-sm-3 order-2 order-sm-3">
                        <small>Bestand</small>
                    </div>
                    <div class="col-sm-12 order-4">
                        <hr class="mt-1 mb-0">
                    </div>
                </div>
                <div class="css_input_container _input_container" id="css_input_container">
                    @foreach($template->css as $cssKey => $cssValue)
                    <div class="form-group row required css_input_line _input_line">
                        <div class="col-6 col-sm-3 order-1">
                            <label class="sr-only" for="css_slug_{{ $cssKey }}">Slug *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-danger remove_line_button" type="button"><i class="fa fa-trash"></i></button>
                                </div>
                                <input type="text" class="form-control form-control-sm css_slug_input" id="css_slug_{{ $cssKey }}" name="css_slug[]" value="{{ $cssKey }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 order-3 order-sm-2">
                            <label class="sr-only" for="css_value_{{ $cssKey }}">URL *</label>
                            <input type="text" class="form-control form-control-sm css_href_input" id="css_value_{{ $cssKey }}" name="css_href[]" value="{{ $cssValue['href'] }}" required>
                        </div>
                        <div class="col-6 col-sm-3 order-2 order-sm-3">
                            <label class="sr-only" for="">Bestand</label>
                            <div class="w-100 d-block mb-lg-1"></div>
                            <input type="hidden" class="css_asset_input_hidden" value="0" name="css_asset[]" @if($cssValue['asset'] == 'true') disabled @endif>
                            <label for="css_asset_{{ $cssKey }}">
                                <input type="checkbox" class="css_asset_input" id="css_asset_{{ $cssKey }}" value="{{ $cssValue['asset'] == 'true' ? 1 : 0 }}" name="css_asset[]" @if($cssValue['asset'] == 'true') checked @endif /> Lokaal
                            </label>
                        </div>
                        <div class="col-sm-12 order-4">
                            <hr class="mb-0">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-group row new_css_input_form py-3">
                    <div class="col-sm-3">
                        <label for="new_css_slug">Slug *</label>
                        <input type="text" class="form-control form-control-sm" id="new_css_slug">
                    </div>
                    <div class="col-sm-3">
                        <label for="new_css_href">URL *</label>
                        <input type="text" class="form-control form-control-sm" id="new_css_href">
                    </div>
                    <div class="col-sm-3">
                        <label for="">Bestand</label>
                        <div class="w-100 d-block mb-lg-1"></div>
                        <label for="new_css_asset">
                            <input type="checkbox" id="new_css_asset" value="1" /> Lokaal
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-outline-success mt-4 mt-md-2" type="button" id="new_css_button">Toevoegen</button>
                        <div class="w-100 d-block"></div>
                        <small class="d-none text-danger" id="new_css_error">Vul alle velden in</small>
                    </div>
                </div>
            </div>


            <div class="col-sm-12 tab-pane fade" id="js" role="tabpanel" aria-labelledby="js-tab">
                <div class="form-group row">
                    <div class="col-6 col-sm-3 order-1">
                        <small>Slug *</small>
                    </div>
                    <div class="col-12 col-sm-6 order-3 order-sm-2">
                        <small>URL *</small>
                    </div>
                    <div class="col-6 col-sm-3 order-2 order-sm-3">
                        <small>Bestand</small>
                    </div>
                    <div class="col-sm-12 order-4">
                        <hr class="mt-1 mb-0">
                    </div>
                </div>
                <div class="js_input_container _input_container" id="js_input_container">
                    @foreach($template->js as $jsKey => $jsValue)
                    <div class="form-group row required js_input_line _input_line">
                        <div class="col-6 col-sm-3 order-1">
                            <label class="sr-only" for="css_slug_{{ $jsKey }}">Slug *</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-danger remove_line_button" type="button"><i class="fa fa-trash"></i></button>
                                </div>
                                <input type="text" class="form-control form-control-sm js_slug_input" id="js_slug_{{ $jsKey }}" name="js_slug[]" value="{{ $jsKey }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 order-3 order-sm-2">
                            <label class="sr-only" for="js_value_{{ $jsKey }}">URL *</label>
                            <input type="text" class="form-control form-control-sm js_href_input" id="js_value_{{ $jsKey }}" name="js_href[]" value="{{ $jsValue['href'] }}" required>
                        </div>
                        <div class="col-6 col-sm-3 order-2 order-sm-3">
                            <label class="sr-only" for="">Bestand</label>
                            <div class="w-100 d-block mb-lg-1"></div>
                            <input type="hidden" class="js_asset_input_hidden" value="0" name="js_asset[]" @if($jsValue['asset'] == 'true') disabled @endif>
                            <label for="js_asset_{{ $jsKey }}">
                                <input type="checkbox" class="js_asset_input" id="js_asset_{{ $jsKey }}" value="{{ $jsValue['asset'] == 'true' ? 1 : 0 }}" name="js_asset[]" @if($jsValue['asset'] == 'true') checked @endif /> Lokaal
                            </label>
                        </div>
                        <div class="col-sm-12 order-4">
                            <hr class="mb-0">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-group row new_js_input_form py-3">
                    <div class="col-sm-3">
                        <label for="new_js_slug">Slug *</label>
                        <input type="text" class="form-control form-control-sm" id="new_js_slug">
                    </div>
                    <div class="col-sm-3">
                        <label for="new_js_href">URL *</label>
                        <input type="text" class="form-control form-control-sm" id="new_js_href">
                    </div>
                    <div class="col-sm-3">
                        <label for="">Bestand</label>
                        <div class="w-100 d-block mb-lg-1"></div>
                        <label for="new_js_asset">
                            <input type="checkbox" id="new_js_asset" value="1" /> Lokaal
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-outline-success mt-4 mt-md-2" type="button" id="new_js_button">Toevoegen</button>
                        <div class="w-100 d-block"></div>
                        <small class="d-none text-danger" id="new_js_error">Vul alle velden in</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <input type="hidden" name="template_id" value="{{ $template->id }}">
                <button class="btn btn-outline-success">Template Opslaan</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('css')
	
@endsection

@section('scripts')
<script>
$(document).ready(function() {
$( "#css_input_container" ).sortable({revert: true});
$( "#js_input_container" ).sortable({revert: true});

$('body').on('change', '.css_asset_input,.js_asset_input', function() {
    if($(this).is(':checked')) {
        $(this).val(1);
        $(this).parent('label').siblings('input').prop('disabled', true);
    } else {
        $(this).val(0);
        $(this).parent('label').siblings('input').prop('disabled', false);
    }
});

$('body').on('click', '.remove_line_button', function() {
    checker = $(this).parents('._input_container').find('._input_line').length;
    if(checker > 1) {
        $(this).parents('._input_line').remove();
    } else {
        $(this).parents('._input_line').addClass('d-none');
        $(this).parents('._input_line').find('input').prop('disabled', true);
    }
});


$('body').on('click', '#new_css_button', function() {
    $('#new_css_error').addClass('d-none');
    if($('#new_css_slug').val().length == 0 || $('#new_css_href').val().length == 0) {
        $('#new_css_error').removeClass('d-none');
        return;
    }

    new_slug = $('#new_css_slug').val();
    new_href = $('#new_css_href').val();
    new_file = $('#new_css_asset').is(':checked');

    if($('.css_input_line').length > 1) {
        $('.css_input_line:first').clone().appendTo('.css_input_container');
        $('.css_input_container').append('<hr>');
    } else {
        $('.css_input_line:first').removeClass('d-none');
        $('.css_input_line:first').find('input').prop('disabled', false);
    }

    $('.css_input_line:last').find('.css_slug_input').attr('id', 'css_slug_'+new_slug);
    $('.css_input_line:last').find('.css_slug_input').val(new_slug);
    $('.css_input_line:last').find('.css_slug_input').siblings('label').attr('for', 'css_href_'+new_slug);

    $('.css_input_line:last').find('.css_href_input').attr('id', 'css_href_'+new_slug);
    $('.css_input_line:last').find('.css_href_input').val(new_href);
    $('.css_input_line:last').find('.css_href_input').siblings('label').attr('for', 'css_href_'+new_slug);

    $('.css_input_line:last').find('.css_asset_input').attr('id', 'css_asset_'+new_slug);
    if(new_file == true) {
        $('.css_input_line:last').find('.css_asset_input').prop('checked', true);
        $('.css_input_line:last').find('.css_asset_input').val(1);
        $('.css_input_line:last').find('.css_asset_input').parent('label').siblings('input').prop('disabled', true);
    } else {
        $('.css_input_line:last').find('.css_asset_input').prop('checked', false);
        $('.css_input_line:last').find('.css_asset_input').val(0);
        $('.css_input_line:last').find('.css_asset_input').parent('label').siblings('input').prop('disabled', false);
    }
    $('.css_input_line:last').find('.css_asset_input').parent('label').attr('for', 'css_asset_'+new_slug);

    $('#new_css_slug').val('');
    $('#new_css_href').val('');
    $('#new_css_asset').prop('checked', false);
});

$('body').on('click', '#new_js_button', function() {
    $('#new_js_error').addClass('d-none');
    if($('#new_js_slug').val().length == 0 || $('#new_js_href').val().length == 0) {
        $('#new_js_error').removeClass('d-none');
        return;
    }

    new_slug = $('#new_js_slug').val();
    new_href = $('#new_js_href').val();
    new_file = $('#new_js_asset').is(':checked');

    if($('.js_input_line').length > 1) {
        $('.js_input_line:first').clone().appendTo('.js_input_container');
        $('.js_input_container').append('<hr>');
    } else {
        $('.js_input_line:first').removeClass('d-none');
        $('.js_input_line:first').find('input').prop('disabled', false);
    }

    $('.js_input_line:last').find('.js_slug_input').attr('id', 'js_slug_'+new_slug);
    $('.js_input_line:last').find('.js_slug_input').val(new_slug);
    $('.js_input_line:last').find('.js_slug_input').siblings('label').attr('for', 'js_href_'+new_slug);

    $('.js_input_line:last').find('.js_href_input').attr('id', 'js_href_'+new_slug);
    $('.js_input_line:last').find('.js_href_input').val(new_href);
    $('.js_input_line:last').find('.js_href_input').siblings('label').attr('for', 'js_href_'+new_slug);

    $('.js_input_line:last').find('.js_asset_input').attr('id', 'js_asset_'+new_slug);
    if(new_file == true) {
        $('.js_input_line:last').find('.js_asset_input').prop('checked', true);
        $('.js_input_line:last').find('.js_asset_input').val(1);
        $('.js_input_line:last').find('.js_asset_input').parent('label').siblings('input').prop('disabled', true);
    } else {
        $('.js_input_line:last').find('.js_asset_input').prop('checked', false);
        $('.js_input_line:last').find('.js_asset_input').val(0);
        $('.js_input_line:last').find('.js_asset_input').parent('label').siblings('input').prop('disabled', false);
    }
    $('.js_input_line:last').find('.js_asset_input').parent('label').attr('for', 'js_asset_'+new_slug);

    $('#new_js_slug').val('');
    $('#new_js_href').val('');
    $('#new_js_asset').prop('checked', false);
});
});
</script>
@endsection