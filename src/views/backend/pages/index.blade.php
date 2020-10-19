@extends('chuckcms::backend.layouts.base')

@section('title')
	Pages
@endsection

@section('add_record')
	@can('create pages')
	<a href="{{ route('dashboard.page.create') }}" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Pagina Toe</a>
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
<script type="text/javascript">
function deletePage(page_id) {
	var token = '{{ Session::token() }}';
		swal({
		title: 'Are you sure?',
		text: "This will also delete all of the pageblocks. You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
	  	if (result.value) { 
	  		$.ajax({
                method: 'POST',
                url: "{{ route('dashboard.page.delete') }}",
                data: { 
                	page_id: page_id, 
                	_token: token
                }
            })
            .done(function (data) {
            	if(data == 'success'){
            		$("#condensedTable").DataTable().row(".page_line[data-id='"+page_id+"']").remove().draw();
            		swal(
			      		'Deleted!',
			      		'The page and its blocks has been deleted.',
			      		'success'
			    	)
            	} else {
            		swal(
			      		'Oops!',
			      		'Something went wrong...',
			      		'danger'
			    	)
            	}

                
            });
	    	
	  	}
	})
}
</script>
@endsection

@section('content')
<div class=" container-fluid container-fixed-lg">
<div class= "container p-3">
    <div class="row">
		<div class="col-lg-12">
		<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
					@can('create pages')
					<div class="pull-right hidden-lg-up">
						<a href="{{ route('dashboard.page.create') }}" class="btn btn-default btn-sm btn-rounded"> Nieuwe Pagina </a>
					</div>
					@endcan
				</div>
				<div class="card-block">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="condensedTable" data-table-count="12">
						<thead>
							<tr>
								<th style="width:7%">ID</th>
								<th style="width:42%">Page</th>
								<th style="width:11%">Status</th>
								<th style="width:40%">Actions</th>
							</tr>
						</thead>
							<tbody>
								@foreach($pages as $page)
								<tr class="page_line" data-id="{{ $page->id }}">
									<td class="v-align-middle">{{ $page->order }}</td>
							    	<td class="v-align-middle semi-bold">{{ $page->title }}</td>
							    	<td class="v-align-middle">
							    		@if($page->active == 1)
											<span class="label label-inverse">Actief</span>
							        	@else
							        		<span class="label">Concept</span>
							        	@endif 
							    	</td>
							    	<td class="v-align-middle semi-bold">
							    		@can('edit pages')
							    		<a href="{{ route('dashboard.page.edit', ['page_id' => $page->id]) }}" class="btn btn-primary btn-sm btn-rounded m-r-10">
							    			<i data-feather="edit-2"></i> 
							    		</a>
							    		@endcan
							    		@can('show pagebuilder')
							    		<a href="{{ route('dashboard.page.edit.pagebuilder', ['page_id' => $page->id]) }}" class="btn btn-default btn-sm btn-rounded m-r-10">
							    			<i data-feather="edit"></i> builder
							    		</a>
							    		@endcan
							    		@can('delete pages')
							    		<a href="#" onclick="deletePage({{ $page->id }})" class="btn btn-danger btn-sm btn-rounded m-r-10 page_delete" data-id="{{ $page->id }}">
							    			<i data-feather="trash"></i> 
							    		</a>
							    		@endcan
							    		@can('edit pages')
							    		<div class="btn-group">
							    			@if(!$loop->last)
					                          	@if(($loop->first && count($pages) > 2))
				                          		<a href="{{ route('dashboard.page.move.last', ['page_id' => $page->id]) }}">
					                          		<button type="button" class="btn btn-xs btn-default">
					                          			<i data-feather="chevrons-down"></i> 
					                          		</button>
					                          	</a>
					                          	@endif
							    			<a href="{{ route('dashboard.page.move.down', ['page_id' => $page->id]) }}">
					                          	<button type="button" class="btn btn-xs btn-default">
					                          		<i data-feather="chevron-down"></i> 
					                          	</button>
				                          	</a>
				                          	@endif
				                          	@if(!$loop->first)
				                          	<a href="{{ route('dashboard.page.move.up', ['page_id' => $page->id]) }}">
				                          		<button type="button" class="btn btn-xs btn-default">
				                          			<i data-feather="chevron-up"></i> 
				                          		</button>
				                          	</a>
					                          	@if(($loop->last && count($pages) > 2))
					                          	<a href="{{ route('dashboard.page.move.first', ['page_id' => $page->id]) }}">
				                          			<button type="button" class="btn btn-xs btn-default">
					                          			<i data-feather="chevrons-up"></i> 
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
		<!-- END card -->
		</div>
		</div>
    </div>
</div>
@endsection