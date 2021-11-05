@extends('chuckcms::backend.layouts.base')

@section('content')
<div class="container p-3 min-height">
  <div class="row">
		<div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.content.repeaters.entries', ['slug' => $content->slug]) }}">Ingaves</a></li>
                  <li class="breadcrumb-item active" aria-current="Repeaters">Maak een nieuwe {{ $content->slug }} ingave</li>
                </ol>
            </nav>
        </div>
	</div>
  <form action="{{ route('dashboard.content.repeaters.entries.save') }}" method="POST" @if($content->content['files'] == 'true') enctype="multipart/form-data" @endif>
    <div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
      <div class="col-lg-12">
        @foreach($content->content['fields'] as $keyName => $input)
          <div class="form-group form-group-default @if($input['required'] == 'true') required @endif">
            @if($input['type'] == 'text' || $input['type'] == 'email' || $input['type'] == 'password')
              <label for="{{$keyName}}">{{ $input['label'] }}</label>
              <input type="{{ $input['type'] }}" name="{{$keyName}}" class="{{ $input['class'] }}" placeholder="{{ $input['placeholder'] }}" value="{{ $input['value'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>
            @endif
            @if($input['type'] == 'image_link')
              <label for="{{$keyName}}">{{ $input['label'] }}</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfm" data-input="{{$keyName.'_'.$loop->iteration}}_input" data-preview="{{$keyName.'_'.$loop->iteration}}_logoholder" class="btn btn-primary img_lfm_link" style="color:#FFF">
                    <i class="fa fa-picture-o"></i> {{ $input['placeholder'] }}
                  </a>
                </span>
                <input id="{{$keyName.'_'.$loop->iteration}}_input" name="{{$keyName}}" class="img_lfm_input {{ $input['class'] }}" accept="image/x-png" type="text" value="{{ $input['value'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>
              </div>
              <img id="{{$keyName.'_'.$loop->iteration}}_logoholder" src="" style="margin-top:15px;max-height:100px;">
            @endif
            @if($input['type'] == 'file')
              <label for="{{$keyName}}">{{ $input['label'] }}</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfm" data-input="{{$keyName.'_'.$loop->iteration}}_input" class="btn btn-primary file_lfm_link" style="color:#FFF">
                    <i class="fa fa-picture-o"></i> {{ $input['placeholder'] }}
                  </a>
                </span>
                <input id="{{$keyName.'_'.$loop->iteration}}_input" name="{{$keyName}}" class="file_lfm_input {{ $input['class'] }}" type="text" value="{{ $input['value'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>
              </div>
            @endif
            @if($input['type'] == 'textarea')
              <label for="{{ $keyName }}">{{ $input['label'] }}</label>
              <textarea name="{{ $keyName }}" class="{{ $input['class'] }}" placeholder="{{ $input['placeholder'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>{{ $input['value'] }}</textarea>
            @endif
            @if($input['type'] == 'wysiwyg')
              <label for="{{ $keyName }}">{{ $input['label'] }}</label>
              <textarea name="{{ $keyName }}" class="summernote-text-editor {{ $input['class'] }}" placeholder="{{ $input['placeholder'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>{!! $input['value'] !!}</textarea>
            @endif
            @if($input['type'] == 'select2')
              <label for="{{ $keyName }}">{{ $input['label'] }}</label>
              <select class="full-width select2 {{ $input['class'] }}" data-init-plugin="select2" name="{{ $keyName }}" data-minimum-results-for-search="-1" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>
                @if(strpos($input['value'], 'repeater:') !== false)
                  @php
                    $repeater_slug = explode(':', $input['value'])[1];
                    $repeater_value = explode(':', $input['value'])[2];
                    $repeater_display = explode(':', $input['value'])[3];
                  @endphp
                  @foreach(ChuckRepeater::for($repeater_slug) as $category)
                    <option value="{{ $category->$repeater_value }}">{{ $category->$repeater_display }}</option>
                  @endforeach
                  @else
                    @foreach(explode('|', $input['value']) as $s2Value)
                      <option value="{{ $s2Value }}">{{ $s2Value }}</option>
                    @endforeach
                @endif
              </select>
            @endif
            @if($input['type'] == 'multiselect2')
              <label for="{{ $keyName }}">{{ $input['label'] }}</label>
              <select class="full-width select2 {{ $input['class'] }}" data-init-plugin="select2" name="{{ $keyName }}[]" data-minimum-results-for-search="-1" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif multiple="multiple">
                @if(strpos($input['value'], 'repeater:') !== false)
                  @php
                    $repeater_slug = explode(':', $input['value'])[1];
                    $repeater_value = explode(':', $input['value'])[2];
                    $repeater_display = explode(':', $input['value'])[3];
                  @endphp
                  @foreach(ChuckRepeater::for($repeater_slug) as $category)
                    <option value="{{ $category->$repeater_value }}">{{ $category->$repeater_display }}</option>
                  @endforeach
                @else
                    @foreach(explode('|', $input['value']) as $s2Value)
                      <option value="{{ $s2Value }}">{{ $s2Value }}</option>
                    @endforeach
                @endif
              </select> 
            @endif
            @if($input['type'] == 'date')
              <label for="{{ $keyName }}">{{ $input['label'] }}</label>
              <input type="text" class="form-control {{ $input['class'] }}" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-week-start="1" name="{{ $keyName }}" value="{{ old($keyName) ? old($keyName) : $input['value'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>
            @endif
            @if($input['type'] == 'datetime')
              <label for="{{ $keyName }}">{{ $input['label'] }}</label>
              <input type="text" class="form-control {{ $input['class'] }}" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-week-start="1" name="{{ $keyName }}" value="{{ old($keyName) ? old($keyName) : $input['value'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif> 
            @endif
          </div>
        @endforeach

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="my-3">
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <input type="hidden" name="content_slug" value="{{ $content->slug }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right m-1" value="1">Opslaan</button>
            <a href="{{ route('dashboard.content.repeaters.entries', ['slug' => $content->slug]) }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
          </p>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('css')
<link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="{{ URL::to('vendor/laravel-filemanager/js/lfm.js') }}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
  <script>
    $( document ).ready(function() { 
      
      init();

      function init () {
        //init media manager inputs 
        var domain = "{{ URL::to('dashboard/media')}}";
        $('.img_lfm_link').filemanager('image', {prefix: domain});

        $('.file_lfm_link').filemanager('file', {prefix: domain});
      }

      $('.summernote-text-editor').summernote({
        fontNames: ['Arial', 'Arial Black', 'Open Sans', 'Helvetica', 'Helvetica Neue', 'Lato']
      });

    });
  </script>
@endsection