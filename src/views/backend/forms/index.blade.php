@extends('chuckcms::backend.layouts.admin')

@section('title')
	Formulieren
@endsection

@section('add_record')
	@can('create pages')
	<a href="{{ route('dashboard.forms.create') }}" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuw Formulier Toe</a>
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
@endsection

@section('content')
<div class=" container-fluid   container-fixed-lg">
    <div class="row">
		<div class="col-lg-12">
		<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
					<div class="card-title">Formulieren</div>
					<div class="tools">
						<a class="collapse" href="javascript:;"></a>
						<a class="config" data-toggle="modal" href="#grid-config"></a>
						<a class="reload" href="javascript:;"></a>
						<a class="remove" href="javascript:;"></a>
					</div>
				</div>
				<div class="card-block">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="condensedTable">
						<thead>
							<tr>
								<th style="width:5%">ID</th>
								<th style="width:25%">Titel</th>
								<th style="width:20%">Slug</th>
								<th style="width:35%">Actions</th>
							</tr>
						</thead>
							<tbody>
								@foreach($forms as $form)
								<tr>
									<td class="v-align-middle">{{ $form->id }}</td>
							    	<td class="v-align-middle semi-bold">{{ $form->title }}</td>
							    	<td class="v-align-middle">{{$form->slug}}</td>
							    	<td class="v-align-middle semi-bold">
							    		@can('edit forms')
							    		<a href="{{ route('dashboard.forms.edit', ['slug' => $form->slug]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i data-feather="edit-2"></i> edit
							    		</a>
							    		@endcan
							    		@can('show formentries')
							    		<a href="{{ route('dashboard.forms.entries', ['slug' => $form->slug]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i data-feather="clipboard"></i> entries
							    		</a>
							    		@endcan
							    		@can('delete forms')
							    		<a href="{{ route('dashboard.forms.delete', ['slug' => $form->slug]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
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
@endsection