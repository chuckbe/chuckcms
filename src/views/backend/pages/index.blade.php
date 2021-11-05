@extends('chuckcms::backend.layouts.base')

@section('title')
	Pagina's
@endsection

@section('add_record')
@can('create pages')
<a href="{{ route('dashboard.page.create') }}" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Pagina Toe</a>
@endcan
@endsection

@section('content')
<div class="container p-3 min-height">
	<div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active" aria-current="page">Pagina's</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
		@can('create pages')
		<div class="col-sm-12 text-right">
    		<a href="{{ route('dashboard.page.create') }}" class="btn btn-sm btn-outline-success"> Nieuwe Pagina </a>
    	</div>
		@endcan
		<div class="col-sm-12 my-3">
			<div class="table-responsive">
				<table class="table" data-datatable style="width:100%">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Page</th>
							<th scope="col">Status</th>
							<th scope="col" style="min-width:170px">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pages as $page)
						<tr class="page_line" data-id="{{ $page->id }}">
							<td>{{ $page->order }}</td>
					    	<td class="semi-bold">{{ $page->title }}</td>
					    	<td>
					    		@if($page->active == 1)
									<span class="label label-inverse">Actief</span>
					        	@else
					        		<span class="label">Concept</span>
					        	@endif 
					    	</td>
					    	<td class="v-align-middle semi-bold">
					    		@can('edit pages')
					    		<a href="{{ route('dashboard.page.edit', ['page_id' => $page->id]) }}" class="btn btn-sm btn-outline-secondary rounded d-inline-block">
									<i class="fa fa-pencil"></i>
					    		</a>
					    		@endcan
					    		@can('show pagebuilder')
					    		<a href="{{ route('dashboard.page.edit.pagebuilder', ['page_id' => $page->id]) }}" class="btn btn-sm btn-outline-secondary rounded d-inline-block">
					    			<i class="fa fa-edit"></i> builder
					    		</a>
					    		@endcan
					    		@can('delete pages')
					    		<a href="#" class="btn btn-danger btn-sm btn-rounded m-r-10 page_delete" data-id="{{ $page->id }}">
					    			<i class="fa fa-trash"></i>
					    		</a>
					    		@endcan
					    		@can('edit pages')
					    		<div class="btn-group">
					    			@if(!$loop->last)
			                          	@if(($loop->first && count($pages) > 2))
		                          		<a href="{{ route('dashboard.page.move.last', ['page_id' => $page->id]) }}">
			                          		<button type="button" class="btn btn-xs btn-default">
												  <i class="fa fa-chevron-down"></i>
			                          		</button>
			                          	</a>
			                          	@endif
					    			<a href="{{ route('dashboard.page.move.down', ['page_id' => $page->id]) }}">
			                          	<button type="button" class="btn btn-xs btn-default">
											  <i class="fa fa-chevron-down"></i>
			                          	</button>
		                          	</a>
		                          	@endif
		                          	@if(!$loop->first)
		                          	<a href="{{ route('dashboard.page.move.up', ['page_id' => $page->id]) }}">
		                          		<button type="button" class="btn btn-xs btn-default">
											  <i class="fa fa-chevron-up"></i>
		                          		</button>
		                          	</a>
			                          	@if(($loop->last && count($pages) > 2))
			                          	<a href="{{ route('dashboard.page.move.first', ['page_id' => $page->id]) }}">
		                          			<button type="button" class="btn btn-xs btn-default">
												  <i class="fa fa-chevron-up"></i>
			                          		</button>
			                      		</a>
			                      		@endif
		                      		@endif
		                        </div>
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
	$('.page_delete').each(function(){
		let page_id = $(this).attr('data-id');
		let token = '{{ Session::token() }}';
		$(this).click(function(event){
			event.preventDefault();
			swal({
				title: 'Are you sure?',
				text: "This will also delete all of the pageblocks. You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result)=>{
				if(result.value) {
	  				$.ajax({
               		method: 'POST',
                	url: "{{ route('dashboard.page.delete') }}",
                	data: { 
                	page_id: page_id, 
                	_token: token
                    }
                }).done(function(data){
				if(data == 'success'){
					$(".page_line[data-id='"+page_id+"']").first().remove();
					swal(
			      		'Deleted!',
			      		'The page and its blocks has been deleted.',
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

