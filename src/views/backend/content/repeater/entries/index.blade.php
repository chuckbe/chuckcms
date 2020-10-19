@extends('chuckcms::backend.layouts.base')

@section('title')
	Repeater | ChuckCMS
@endsection

@section('add_record')
	@can('create repeaters entry')
	<a href="{{ route('dashboard.content.repeaters.entries.create', ['slug' => $content->slug]) }}" class="btn btn-link text-primary m-l-20 hidden-md-down" style="text-transform:capitalize">Voeg Nieuwe {{ $content->slug }} Toe</a>
	@endcan
@endsection

@section('css')
	<link href="https://cdn.chuck.be/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.chuck.be/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.chuck.be/assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen" />
@endsection

@section('scripts')
	<script src="https://cdn.chuck.be/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.chuck.be/assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
    <script type="text/javascript" src="https://cdn.chuck.be/assets/plugins/datatables-responsive/js/lodash.min.js"></script>
    <script src="https://cdn.chuck.be/assets/js/tables.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/sweetalert2.all.js"></script>
    <script>
    $( document ).ready(function (){
    	$('.repeater_delete').each(function(){
			var repeater_id = $(this).attr("data-id");
			var token = '{{ Session::token() }}';
		  	$(this).click(function (event) {
		  		event.preventDefault();
		  		swal({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
				  	if (result.value) { 
				  		$.ajax({
	                        method: 'POST',
	                        url: "{{ route('dashboard.content.repeaters.entries.delete') }}",
	                        data: { 
	                        	repeater_id: repeater_id, 
	                        	_token: token
	                        }
	                    })
	                    .done(function (data) {
	                    	console.log('data :: ', data);

	                        $(".repeater_line[data-id='"+repeater_id+"']").first().remove();
	                    });
				    	swal(
				      		'Deleted!',
				      		'The repeater has been deleted.',
				      		'success'
				    	)
				  	}
				})
		    });
		});
    });

    </script>
@endsection

@section('content')
<div class=" container-fluid   container-fixed-lg">
<div class="container p-3>"
    <div class="row">
		<div class="col-lg-12">
		<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
					<div class="card-title">Repeaters</div>
					<div class="tools">
						<a class="collapse" href="javascript:;"></a>
						<a class="config" data-toggle="modal" href="#grid-config"></a>
						<a class="reload" href="javascript:;"></a>
						<a class="remove" href="javascript:;"></a>
					</div>
				</div>
				<div class="card-block">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="condensedTable" data-table-count="10">
						<thead>
							<tr>
								<th style="width:5%">ID</th>
								@foreach($content->content['fields'] as $rKey => $rValue)
									@if($rValue['table'] == 'true')
									<th style="width:20%">
										{{ str_replace($content->slug . '_', '', $rKey) }}
									</th>
									@endif
								@endforeach
								<th style="width:15%">Actions</th>
							</tr>
						</thead>
							<tbody>
								@foreach($repeaters as $repeater)
								<tr class="repeater_line" data-id="{{ $repeater->id }}">
									<td class="v-align-middle">{{ $repeater->id }}</td>
							    	@foreach($content->content['fields'] as $rKey => $rValue)
										@if($rValue['table'] == 'true')
										<td class="v-align-middle">
											@if(array_key_exists(str_replace($content->slug . '_', '', $rKey), $repeater->json))
											@if($rValue['type'] == 'select2' && strpos($rValue['value'], 'repeater:') !== false)
											@php
											$repeater_display = explode(':', $rValue['value'])[3];
											@endphp
											{{ ChuckRepeater::find($repeater->json[str_replace($content->slug . '_', '', $rKey)])->$repeater_display }}
											@else
											{{ $repeater->json[str_replace($content->slug . '_', '', $rKey)] }}
											@endif
											@endif
										</td>
										@endif
									@endforeach
							    	<td class="v-align-middle semi-bold">
							    		@can('edit repeaters entry')
							    		<a href="{{ route('dashboard.content.repeaters.entries.edit', ['slug' => $repeater->slug, 'id' => $repeater->id]) }}" class="btn btn-primary btn-sm btn-rounded m-r-20">
							    			<i data-feather="edit-2"></i> edit
							    		</a>
							    		@endcan
							    		@can('delete repeaters entry')
							    		<a href="#" class="btn btn-danger btn-sm btn-rounded m-r-20 repeater_delete" data-id="{{ $repeater->id }}">
							    			<i data-feather="trash"></i> delete
							    		</a>
							    		@endcan
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
</div>
@endsection