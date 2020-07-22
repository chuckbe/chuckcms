@extends('chuckcms::backend.layouts.admin')

@section('title')
	Repeater | ChuckCMS
@endsection

@section('add_record')
	@can('create repeaters')
	<a href="{{ route('dashboard.content.repeaters.create') }}" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Repeater Toe</a>
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
    		<div class="text-right">
    			<button data-target="#importRepeaterModal" data-toggle="modal" class="btn btn-success">Importeren</button>
    		</div>
    	</div>
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
						<table class="table table-hover table-condensed" id="condensedTable" data-table-count="12">
						<thead>
							<tr>
								<th style="width:10%">ID</th>
								<th style="width:30%">Slug</th>
								<th style="width:15%">Subpages?</th>
								<th style="width:45%">Actions</th>
							</tr>
						</thead>
							<tbody>
								@foreach($repeaters as $repeater)
								<tr>
									<td class="v-align-middle">{{ $repeater->id }}</td>
							    	<td class="v-align-middle">{{$repeater->slug}}</td>
							    	<td class="v-align-middle">
							    		@if($repeater->content['actions']['detail'] !== "false")
											<span class="label label-inverse">Yes</span>
							        	@else
							        		<span class="label">No</span>
							        	@endif 
							    	</td>
							    	<td class="v-align-middle semi-bold">
							    		@can('show repeaters entries')
							    		<a href="{{ route('dashboard.content.repeaters.entries', ['slug' => $repeater->slug]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i data-feather="clipboard"></i> entries
							    		</a>
							    		@endcan
							    		@can('edit repeaters')
							    		<a href="{{ route('dashboard.content.repeaters.edit', ['slug' => $repeater->slug]) }}" class="btn btn-primary btn-sm btn-rounded m-r-20">
							    			<i data-feather="edit-2"></i> 
							    		</a>
							    		@endcan
							    		@can('delete repeaters')
							    		<a href="{{ route('dashboard.forms.delete', ['slug' => $repeater->slug]) }}" class="btn btn-danger btn-sm btn-rounded m-r-20">
							    			<i data-feather="trash"></i> 
							    		</a>
							    		@endcan
							    		@can('show repeaters')
							    		<a href="{{ route('dashboard.content.repeaters.json', ['slug' => $repeater->slug]) }}" class="btn btn-warning btn-sm btn-rounded m-r-20">
							    			<i data-feather="download"></i> 
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
@include('chuckcms::backend.content.repeater._import_modal')
@endsection