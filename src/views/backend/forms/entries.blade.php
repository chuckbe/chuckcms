@extends('chuckcms::backend.layouts.admin')

@section('title')
	Formulier Ingaves
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
    <script>
    (function($) {

	    'use strict';

	    // Initialize a dataTable with collapsible rows to show more details
	    var initDetailedViewTable = function() {
$.fn.dataTable.ext.errMode = 'none';


	        var table = $('#detailTable');

	        table.DataTable({
	            "sDom": "t",
	            "scrollCollapse": true,
	            "paging": false,
	            "bSort": false
	        });

	        // Add event listener for opening and closing details
	        $('#detailTable tbody').on('click', 'tr', function() {
	            //var row = $(this).parent()
	            if ($(this).hasClass('shown') && $(this).next().hasClass('row-details')) {
	                $(this).removeClass('shown');
	                $(this).next().addClass('collapse');
	                return;
	            }
	            var tr = $(this).closest('tr');
	            var row = table.DataTable().row(tr);

	            $(this).parents('tbody').find('.shown').removeClass('shown');
	            
	            tr.addClass('shown');
	            tr.next().removeClass('collapse');
	        });

	    }

	    initDetailedViewTable();

	})(window.jQuery);
    </script>
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
						<table class="table table-hover table-condensed table-detailed" id="detailTable">
						<thead>
							<tr>
								<th style="width:5%">ID</th>
								<th style="width:30%">Slug</th>
								<th style="width:30%">Date</th>
								<th style="width:35%">Actions</th>
							</tr>
						</thead>
							<tbody>
								@foreach($entries as $entry)
								<tr>
									<td class="v-align-middle">{{ $entry->id }}</td>
							    	<td class="v-align-middle semi-bold">{{ $form->slug }}</td>
							    	<td class="v-align-middle semi-bold">{{ date('d/m/Y - H:i:s', strtotime($entry->created_at)) }}</td>
							    	<td class="v-align-middle semi-bold">
							    		@can('show formentries')
							    		<a href="{{ route('dashboard.forms.entry', ['slug' => $form->slug, 'id' => $entry->id]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i data-feather="edit-2"></i> bekijken
							    		</a>
							    		@endcan
							    	</td>
							  	</tr>
								  	<tr class="row-details collapse">
			                          	<td colspan="4">
			                          		<table class="table table-inline">
			                          			<tbody>
			                          				@foreach($entry->entry as $entryKey => $entryValue)
			                          				<tr>
			                          					<td>{{ $entryKey }}</td>
			                          					<td>
			                          						@if(is_array($entryValue))
			                          						{!! implode('<br>', $entryValue) !!}
			                          						@else
			                          						{{ $entryValue }}@endif
			                          					</td>
			                          				</tr>
			                          				@endforeach
			                          			</tbody>
			                          		</table>
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