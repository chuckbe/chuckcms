@extends('chuckcms::backend.layouts.base')

@section('title')
	Formulier '{{ $form->slug }}' Ingave #{{ $entry->id}}
@endsection

@section('content')
<div class="container p-3 min-height">
	<div class="row">
		<div class="col-sm-12">
			<nav aria-label="breadcumb">
				<ol class="breadcrumb mt-3">
					<li class="breadcrumb-item active" aria-current="Ingaves">Ingaves</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
		<div class="col-sm-12 my-3">
			<div class="table-responsive">
				<table class="table" data-datatable style="width:100%">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Veld</th>
							<th scope="col">Waarde</th>
						</tr>
					</thead>
					<tbody>
						@foreach($entry->entry as $entryKey => $entryValue)
							<tr class="page_line" data-id="{{ $loop->iteration }}">
								<td>{{ $loop->iteration }}</td>
								<td class="semi-bold">{{ $entryKey }}</td>
								<td class="v-align-middle semi-bold">
									@if(is_array($entryValue))
                  						{!! implode('<br>', $entryValue) !!}
                  						@else
                  						{{ $entryValue }}
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('css')

@endsection

@section('scripts')

@endsection
