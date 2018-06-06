<form action="{{ route('forms.validate') }}" method="post" @if($form->form['files'] == 'true') enctype="multipart/form-data" @endif>
	
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

	<button type="submit" class="{{ $form->form['button']['class'] }}" id="{{ $form->form['button']['id'] }}">{{ $form->form['button']['label'] }}</button>
</form>