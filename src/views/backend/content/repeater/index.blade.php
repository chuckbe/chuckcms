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
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<a class="config" data-toggle="modal" href="#grid-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
		</div>
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
							<tr>
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
							    		<a href="{{ route('dashboard.content.repeaters.entries', ['slug' => $repeater->slug]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i class="fa fa-clipboard"></i> entries
							    		</a>
							    	@endcan
									@can('edit repeaters')
							    		<a href="{{ route('dashboard.content.repeaters.edit', ['slug' => $repeater->slug]) }}" class="btn btn-primary btn-sm btn-rounded m-r-20">
							    			<i class="fa fa-edit"></i> 
							    		</a>
							    	@endcan
									@can('delete repeaters')
							    		<a href="{{ route('dashboard.forms.delete', ['slug' => $repeater->slug]) }}" class="btn btn-danger btn-sm btn-rounded m-r-20">
							    			<i class="fa fa-trash"></i> 
							    		</a>
							    	@endcan
									@can('show repeaters')
							    		<a href="{{ route('dashboard.content.repeaters.json', ['slug' => $repeater->slug]) }}" class="btn btn-warning btn-sm btn-rounded m-r-20">
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

