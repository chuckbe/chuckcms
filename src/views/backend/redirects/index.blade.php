@extends('chuckcms::backend.layouts.base')

@section('title')
	Redirects
@endsection

@section('add_record')
	@can('create redirects')
	<a href="#" data-target="#createRedirectModal" data-toggle="modal" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Redirect Toe</a>
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
    <script type="text/javascript">
    $(document).ready(function() {

    	$(".no-special-but-hyphens").keyup(function(){
		    var text = $(this).val();
		    slug_text = text.toLowerCase().replace(/[^A-Za-z-]/g, "").replace(/ +/g,'-');
		    $(this).val(slug_text);  
		});

    });

    function editModal(id, slug, to, type){
    	$('#edit_redirect_id').val(id);
    	$('#edit_redirect_slug').val(slug);
    	$('#edit_redirect_to').val(to);
    	$('#edit_redirect_type').val(type).trigger('change');
    	$('#editRedirectModal').modal('show');
    }

    function deleteModal(id, slug, to){
    	$('#delete_redirect_id').val(id);
    	$('#delete_redirect_slug').text(slug);
    	$('#delete_redirect_to').text(to);
    	$('#deleteRedirectModal').modal('show');
    }
    </script>
@endsection

@section('content')
<div class=" container-fluid   container-fixed-lg">
<div class="container p-3">
    <div class="row">
		<div class="col-lg-12">
		<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
					<div class="card-title">Redirects</div>
					@can('create redirects')
					<div class="pull-right hidden-lg-up">
						<a href="#" data-target="#createRedirectModal" data-toggle="modal" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Redirect Toe</a>
						{{-- <a href="{{ route('dashboard.page.create') }}" class="btn btn-default btn-sm btn-rounded"> Nieuwe Pagina </a> --}}
					</div>
					@endcan
					<div class="tools">
						<a class="collapse" href="javascript:;"></a>
						<a class="config" data-toggle="modal" href="#grid-config"></a>
						<a class="reload" href="javascript:;"></a>
						<a class="remove" href="javascript:;"></a>
					</div>
				</div>
				<div class="card-block">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="condensedTable" data-table-count="6">
						<thead>
							<tr>
								<th style="width:5%">ID</th>
								<th style="width:20%">Van</th>
								<th style="width:35%">Naar</th>
								<th style="width:15%">Type</th>
								<th style="width:25%">Actions</th>
							</tr>
						</thead>
							<tbody>
								@foreach($redirects as $redirect)
								<tr>
									<td class="v-align-middle">{{ $redirect->id }}</td>
							    	<td class="v-align-middle semi-bold">{{ $redirect->slug }}</td>
							    	<td class="v-align-middle">{{$redirect->to }}</td>
							    	<td class="v-align-middle">
							    		<span class="label label-success">{{$redirect->type}}</span>
							    	</td>
							    	<td class="v-align-middle semi-bold">
							    		@can('edit redirects')
							    		<a href="#" onclick="editModal({{ $redirect->id }}, '{{ $redirect->slug }}', '{{ $redirect->to }}', {{ $redirect->type }} )" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i data-feather="edit-2"></i> edit
							    		</a>
							    		@endcan

							    		@can('delete redirects')
							    		<a href="#" onclick="deleteModal({{ $redirect->id }}, '{{ $redirect->slug }}', '{{ $redirect->to }}')" class="btn btn-danger btn-sm btn-rounded m-r-20">
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
@can('create redirects')
	@include('chuckcms::backend.redirects._create_modal')
@endcan
@can('edit redirects')
	@include('chuckcms::backend.redirects._edit_modal')
@endcan
@can('delete redirects')
	@include('chuckcms::backend.redirects._delete_modal')
@endcan
@endsection