@extends('chuckcms::backend.layouts.admin')

@section('title')
	Formulier '{{ $form->slug }}' Ingave #{{ $entry->id}}
@endsection

@section('css')
	<link href="{{ URL::to('chuckbe/chuckcms/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('chuckbe/chuckcms/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('chuckbe/chuckcms/assets/plugins/datatables-responsive/css/datatables.responsive.css') }}" rel="stylesheet" type="text/css" media="screen" />
@endsection

@section('scripts')
	<script src="{{ URL::to('chuckbe/chuckcms/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('chuckbe/chuckcms/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('chuckbe/chuckcms/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('chuckbe/chuckcms/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ URL::to('chuckbe/chuckcms/assets/plugins/datatables-responsive/js/datatables.responsive.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('chuckbe/chuckcms/assets/plugins/datatables-responsive/js/lodash.min.js') }}"></script>
    <script src="{{ URL::to('chuckbe/chuckcms/assets/js/tables.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class=" container-fluid   container-fixed-lg">
    <div class="row">
		<div class="col-lg-12">
		<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
					<div class="card-title">Ingaves</div>
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
								<th style="width:35%">Veld</th>
								<th style="width:60%">Waarde</th>
							</tr>
						</thead>
							<tbody>
								@foreach($entry->entry as $entryKey => $entryValue)
								<tr>
									<td class="v-align-middle">{{ $loop->iteration }}</td>
									<td class="v-align-middle">{{ $entryKey }}</td>
							    	<td class="v-align-middle semi-bold">{{ $entryValue }}</td>
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