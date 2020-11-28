@extends('chuckcms::backend.layouts.admin')

@section('title')
	Formulier '{{ $form->slug }}' Ingave #{{ $entry->id}}
@endsection

@section('css')

@endsection

@section('scripts')

@endsection

@section('content')
<div class=" container-fluid   container-fixed-lg">
    <div class="row">
		<div class="col-lg-12">
		<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
					<div class="card-title">Ingaves</div>
				</div>
				<div class="card-block">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" data-datatable style="width:100%">
						<thead>
							<tr>
								<th style="width:5%">ID</th>
								<th style="width:35%">Veld</th>
								<th style="width:60%">Waarde</th>
							</tr>
						</thead>
							<tbody>
								@foreach($entry->entry as $entryKey => $entryValue)
								<tr>
									<td class="v-align-middle">{{ $loop->iteration }}</td>
									<td class="v-align-middle">{{ $entryKey }}</td>
							    	<td class="v-align-middle semi-bold">
							    		@if(is_array($entryValue))
                  						{!! implode('<br>', $entryValue) !!}
                  						@else
                  						{{ $entryValue }}@endif
							    	</td>
							  	</tr>
							  	@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<!-- END card -->
		</div>
    </div>
</div>
@endsection