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

                    @if($input['type'] == 'textarea')
                      <label for="{{ $keyName }}">{{ $input['label'] }}</label>
                      <textarea name="{{ $keyName }}" class="{{ $input['class'] }}" placeholder="{{ $input['placeholder'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>{{ $input['value'] }}</textarea>
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
@endsection

@section('scripts')
  <script>
    
  </script>
@endsection