<form id="ccms_form_{{ $form->slug }}" action="{{ route('forms.validate') }}" method="post" @if($form->form['files'] == 'true' || $form->form['files'] == true) enctype="multipart/form-data" @endif>
	
@foreach($form->form['fields'] as $keyName => $input)
	<div class="form-group {{ array_key_exists('parentclass', $input) ? $input['parentclass'] : '' }}">
		@if($input['type'] == 'text' || $input['type'] == 'email' || $input['type'] == 'password')
			<label for="{{$keyName}}">{{ $input['label'] }}</label>
			<input type="{{ $input['type'] }}" name="{{$keyName}}" class="{{ $input['class'] }}" placeholder="{{ $input['placeholder'] }}" value="{{ old($keyName) ? old($keyName) : $input['value'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>
		@endif

		@if($input['type'] == 'textarea')
			<label for="{{ $keyName }}">{{ $input['label'] }}</label>
			<textarea name="{{ $keyName }}" class="{{ $input['class'] }}" placeholder="{{ $input['placeholder'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>{{ old($keyName) ? old($keyName) : $input['value'] }}</textarea>
		@endif

		@if($input['type'] == 'file')
			<label for="{{ $keyName }}">{{ $input['label'] }}</label>
			<input type="file" name="{{$keyName}}" class="{{ $input['class'] }}" placeholder="{{ $input['placeholder'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif>
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

		@if($input['type'] == 'checkbox')
			<div class="checkbox">
				<label for="{{ $keyName }}">
					<input type="checkbox" class="{{ $input['class'] }}" name="{{ $keyName }}" value="{{ old($keyName) ? old($keyName) : $input['value'] }}" @if($input['attributes'] !== '') @foreach($input['attributes'] as $attrName => $attrValue) {{ $attrName }}="{{ $attrValue }}" @endforeach @endif @if($input['required'] == 'true') required @endif> {{ $input['label'] }}
				</label>
			</div>
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