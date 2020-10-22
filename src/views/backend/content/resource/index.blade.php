@extends('chuckcms::backend.layouts.base')

@section('title')
	Resources
@endsection

@section('add_record')
	@can('create pages')
	<a href="{{ route('dashboard.content.resources.create') }}" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Resource Toe</a>
	@endcan
@endsection

@section('content')
<div class="container p-3">
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
		@can('create pages')
		<div class="col-sm-12 text-right">
			<a href="{{ route('dashboard.content.resources.create') }}" class="btn btn-sm btn-outline-success">Voeg Nieuwe Resource Toe</a>
		</div>
		@endcan
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<a class="config" data-toggle="modal" href="#grid-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
		</div>
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
							<tr>
								<td>{{ $resource->id }}</td>
								<td>{{ $resource->slug }}</td>
								<td class="semi-bold">
									@can('edit forms')
										<a href="{{ route('dashboard.content.resources.edit', ['slug' => $resource->slug]) }}" class="btn btn-sm btn-outline-secondary rounded d-inline-block">
							    			<i class="fa fa-pencil"></i> edit
							    		</a>
									@endcan
									@can('delete forms')
							    		<a href="{{ route('dashboard.forms.delete', ['slug' => $resource->slug]) }}" class="btn btn-danger btn-sm btn-rounded m-r-20 disabled">
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
	{{-- <link href="https://cdn.chuck.be/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" /> --}}
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
@endsection

