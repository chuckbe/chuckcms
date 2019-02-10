@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid   container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.content.repeaters.entries.save') }}" method="POST" @if($content->content['files'] == 'true') enctype="multipart/form-data" @endif>
<div class="card card-transparent">
  <div class="card-block">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-transparent">
          
          <div class="card-header ">
            <div class="card-title">Maak een nieuwe {{ $content->slug }} ingave</div>
          </div>

          <div class="card-block">
            <div class="row column-seperation">
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
                        @foreach(explode('|', $input['value']) as $s2Value)
                        <option value="{{ $s2Value }}">{{ $s2Value }}</option>
                        @endforeach
                      </select>
                    @endif
                    @if($input['type'] == 'multiselect2')
                      <label for="{{ $keyName }}">{{ $input['label'] }}</label>
                      <select class="full-width select2 {{ $input['class'] }}" data-init-plugin="select2" name="{{ $keyName }}[]" data-minimum-results-for-search="-1" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif multiple="multiple">
                        @foreach(explode('|', $input['value']) as $s2Value)
                        <option value="{{ $s2Value }}">{{ $s2Value }}</option>
                        @endforeach
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
          </div>
          <br>
          <p class="pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <input type="hidden" name="content_slug" value="{{ $content->slug }}">
            <button type="submit" name="create" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a href="{{ route('dashboard.content.repeaters.entries', ['slug' => $content->slug]) }}" class="pull-right"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
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
      }

      $('.summernote-text-editor').summernote({
        fontNames: ['Arial', 'Arial Black', 'Open Sans', 'Helvetica', 'Helvetica Neue', 'Lato']
      });

    });
  </script>
@endsection