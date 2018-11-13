<form id="ccms_form_{{ $form->slug }}" action="{{ route('forms.validate') }}" method="post" @if($form->form['files'] == 'true') enctype="multipart/form-data" @endif>
	
@foreach($form->form['fields'] as $keyName => $input)
	<div class="form-group">
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

	<input type="hidden" value="{{ csrf_token() }}" name="_token">
	{!! Honeypot::generate('chuckpot', 'chucktime') !!}
	<input type="hidden" value="{{ $form->slug }}" name="_form_slug">
	<button type="submit" class="{{ $form->form['button']['class'] }}" id="{{ $form->form['button']['id'] }}">{{ $form->form['button']['label'] }}</button>
</form>