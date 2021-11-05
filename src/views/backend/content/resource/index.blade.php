@extends('chuckcms::backend.layouts.base')

@section('title')
	Resources
@endsection

@section('add_record')
	@can('create resource')
	<a href="{{ route('dashboard.content.resources.create') }}" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Resource Toe</a>
	@endcan
@endsection

@section('content')
<div class="container p-3 min-height">
	<div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active" aria-current="Resources">Resources</li>
                </ol>
            </nav>
        </div>
    </div>
	<div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
		@can('create resource')
		<div class="col-sm-12 text-right">
			<a href="{{ route('dashboard.content.resources.create') }}" class="btn btn-sm btn-outline-success">Voeg Nieuwe Resource Toe</a>
		</div>
		@endcan
		<div class="col-sm-12 my-3">
			<div class="table-responsive">
				<table class="table" data-datatable style="width:100%">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Slug</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($resources as $resource)
							<tr class="resource_line" data-id="{{ $resource->id }}">
								<td>{{ $resource->id }}</td>
								<td>{{ $resource->slug }}</td>
								<td class="semi-bold">
									@can('edit resource')
										<a href="{{ route('dashboard.content.resources.edit', ['slug' => $resource->slug]) }}" class="btn btn-sm btn-outline-secondary rounded d-inline-block">
							    			<i class="fa fa-pencil"></i> edit
							    		</a>
									@endcan
									@can('delete resource')
							    		<a href="#" class="btn btn-danger btn-sm btn-rounded m-r-20 resource_delete" data-id="{{ $resource->id }}">
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
<script type="text/javascript">
$(document).ready(function(){
	$('.resource_delete').each(function(){
		let resource_id = $(this).attr('data-id');
		let token = '{{ Session::token() }}';
		$(this).click(function(event){
			event.preventDefault();
			swal({
				title: 'Are you sure?',
				text: "This will delete the resource in all active languages. You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result)=>{
				if(result.value) {
	  				$.ajax({
               		method: 'POST',
                	url: "{{ route('dashboard.content.resources.delete') }}",
                	data: { 
                		resource_id: resource_id, 
                		_token: token
                    }
                }).done(function(data){
				if(data == 'success'){
					$(".resource_line[data-id='"+resource_id+"']").first().remove();
					swal(
			      		'Deleted!',
			      		'The resource has been deleted.',
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

