@extends('chuckcms::backend.layouts.base')

@section('title')
	Repeater | ChuckCMS
@endsection

@section('add_record')
	@can('create repeaters entry')
	<a href="{{ route('dashboard.content.repeaters.entries.create', ['slug' => $content->slug]) }}" class="btn btn-link text-primary m-l-20 hidden-md-down" style="text-transform:capitalize">Voeg Nieuwe {{ $content->slug }} Toe</a>
	@endcan
@endsection

@section('content')
<div class="container p-3">
	<div class="row">
    	<div class="col-sm-12">
        	<nav aria-label="breadcrumb">
            	<ol class="breadcrumb mt-3">
                	<li class="breadcrumb-item active" aria-current="Repeaters">Repeaters</li>
           		</ol>
        	</nav>
    	</div>
  	</div>
	<div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<a class="config" data-toggle="modal" href="#grid-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
		</div>
		@can('create repeaters entry')
		<div class="col-sm-12 text-right">
			<a href="{{ route('dashboard.content.repeaters.entries.create', ['slug' => $content->slug]) }}" class="btn btn-sm btn-outline-success">Voeg {{ ucfirst($content->slug) }} Toe</a>
		</div>
		@endcan
		<div class="col-sm-12 my-3">
			<div class="table-responsive">
				<table class="table" data-datatable style="width:100%">
					<thead>
						<tr>
							<th scope="col">ID</th>
							@foreach($content->content['fields'] as $rKey => $rValue)
								@if($rValue['table'] == 'true')
									<th scope="col">
										{{ str_replace($content->slug . '_', '', $rKey) }}
									</th>
								@endif
							@endforeach
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($repeaters as $repeater)
							<tr class="repeater_line" data-id="{{ $repeater->id }}">
								<td>{{ $repeater->id }}</td>
								@foreach($content->content['fields'] as $rKey => $rValue)
									@if($rValue['table'] == 'true')
										<td>
											@if(array_key_exists(str_replace($content->slug . '_', '', $rKey), $repeater->json))
												@if($rValue['type'] == 'select2' && strpos($rValue['value'], 'repeater:') !== false)
													@php
														$repeater_display = explode(':', $rValue['value'])[3];
													@endphp
													{{ ChuckRepeater::find($repeater->json[str_replace($content->slug . '_', '', $rKey)])->$repeater_display }}
												@elseif($rValue['type'] == 'multiselect2' && strpos($rValue['value'], 'repeater:') !== false)
													@php
														$repeater_display = explode(':', $rValue['value'])[3];
													@endphp
													@foreach ($repeater->json[str_replace($content->slug . '_', '', $rKey)] as $multirelationship)
														{{ ChuckRepeater::find($multirelationship)->$repeater_display.(!$loop->last ? ', ' : '') }}
													@endforeach
												@else
													{{ is_array($repeater->json[str_replace($content->slug . '_', '', $rKey)]) ? implode(', ', $repeater->json[str_replace($content->slug . '_', '', $rKey)]) : $repeater->json[str_replace($content->slug . '_', '', $rKey)] }}
												@endif
											@endif
										</td>
									@endif
								@endforeach
								<td class="semi-bold">
									@can('edit repeaters entry')
							    		<a href="{{ route('dashboard.content.repeaters.entries.edit', ['slug' => $repeater->slug, 'id' => $repeater->id]) }}" class="btn btn-primary btn-sm btn-rounded m-r-20">
							    			<i class="fa fa-edit"></i> edit
							    		</a>
							    	@endcan
							    	@can('delete repeaters entry')
							    		<a href="#" class="btn btn-danger btn-sm btn-rounded m-r-20 repeater_delete" data-id="{{ $repeater->id }}">
							    			<i class="fa fa-trash"></i> delete
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
</div>
@endsection

@section('css')

@endsection

@section('scripts')
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
