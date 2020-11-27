@extends('chuckcms::backend.layouts.base')

@section('title')
	Repeater | ChuckCMS
@endsection

@section('add_record')
	@can('create repeaters')
	<a href="{{ route('dashboard.content.repeaters.create') }}" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Repeater Toe</a>
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
		@can('create repeaters')
			<div class="col-sm-12 text-right">
				<a href="{{ route('dashboard.content.repeaters.create') }}" class="btn btn-sm btn-outline-success">Voeg Nieuwe Repeater Toe</a>
				<button data-target="#importRepeaterModal" data-toggle="modal" class="btn btn-sm btn-outline-success">Importeren</button>
			</div>
		@endcan
		<div class="col-sm-12 my-3">
			<div class="table-responsive">
				<table class="table table-condensed" data-datatable style="width:100%">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Slug</th>
							<th scope="col">Subpages?</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($repeaters as $repeater)
							<tr class="content_line" data-id="{{ $repeater->id }}">
								<td>{{ $repeater->id }}</td>
								<td>{{$repeater->slug}}</td>
								<td>
									@if($repeater->content['actions']['detail'] !== "false")
										<span class="label label-inverse">Yes</span>
							        	@else
							        		<span class="label">No</span>
							        @endif 
								</td>
								<td class="semi-bold">
									@can('show repeaters entries')
							    		<a href="{{ route('dashboard.content.repeaters.entries', ['slug' => $repeater->slug]) }}" class="btn btn-default btn-sm btn-rounded">
							    			<i class="fa fa-clipboard"></i> entries
							    		</a>
							    	@endcan
									@can('edit repeaters')
							    		<a href="{{ route('dashboard.content.repeaters.edit', ['slug' => $repeater->slug]) }}" class="btn btn-primary btn-sm btn-rounded">
							    			<i class="fa fa-edit"></i> 
							    		</a>
							    	@endcan
									@can('delete repeaters')
							    		<a href="#" class="btn btn-danger btn-sm btn-rounded content_delete" data-id="{{ $repeater->id }}">
							    			<i class="fa fa-trash"></i> 
							    		</a>
							    	@endcan
									@can('show repeaters')
							    		<a href="{{ route('dashboard.content.repeaters.json', ['slug' => $repeater->slug]) }}" class="btn btn-warning btn-sm btn-rounded">
							    			<i class="fa fa-download"></i> 
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
@include('chuckcms::backend.content.repeater._import_modal')
@endsection

@section('css')

@endsection

@section('scripts')
<script src="https://cdn.chuck.be/assets/plugins/sweetalert2.all.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.content_delete').each(function(){
		let content_id = $(this).attr('data-id');
		let token = '{{ Session::token() }}';
		$(this).click(function(event){
			event.preventDefault();
			swal({
				title: 'Are you sure?',
				text: "This will delete the repeater and all including entries. You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result)=>{
				if(result.value) {
	  				$.ajax({
               		method: 'POST',
                	url: "{{ route('dashboard.content.repeaters.delete') }}",
                	data: { 
                		content_id: content_id, 
                		_token: token
                    }
                }).done(function(data){
				if(data == 'success'){
					$(".content_line[data-id='"+content_id+"']").first().remove();
					swal(
			      		'Deleted!',
			      		'The repeater and all including entries has been deleted.',
			      		'success'
			    	)
				} else{
					swal(
			      		'Oops!',
			      		'Something went wrong...',
			      		'danger'
			    	)
				}
			})
            }
			})
		})
	})
})
</script>
@endsection

