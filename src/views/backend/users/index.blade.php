@extends('chuckcms::backend.layouts.admin')

@section('title')
	Gebruikers
@endsection

@section('add_record')
	@can('create users')
	<a href="#" data-target="#newUserModal" data-toggle="modal" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Gebruiker Toe</a>
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
    @if (session('notification'))
    	@include('chuckcms::backend.includes.notification')
	@endif
	<script src="https://cdn.chuck.be/assets/plugins/sweetalert2.all.js"></script>
	<script type="text/javascript">
	function deleteUser(user_id) {
		var token = '{{ Session::token() }}';
			swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  	if (result.value) { 
		  		$.ajax({
	                method: 'POST',
	                url: "{{ route('dashboard.user.delete') }}",
	                data: { 
	                	user_id: user_id, 
	                	_token: token
	                }
	            })
	            .done(function (data) {
	            	if(data == 'success'){
	            		$("#condensedTable").DataTable().row(".user_line[data-id='"+user_id+"']").remove().draw();
	            		swal(
				      		'Deleted!',
				      		'The user has been deleted.',
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

	function resendInvitationUser(user_id) {
		var token = '{{ Session::token() }}';
			swal({
			title: 'Resend invitation e-mail?',
			text: "The user will be able to reset their password!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, send it!'
		}).then((result) => {
		  	if (result.value) { 
		  		$.ajax({
	                method: 'POST',
	                url: "{{ route('dashboard.user.resend.invitation') }}",
	                data: { 
	                	user_id: user_id, 
	                	_token: token
	                }
	            })
	            .done(function (data) {
	            	if(data == 'success'){
	            		swal(
				      		'Sent!',
				      		'A new invitation e-mail has been sent.',
				      		'success'
				    	)
	            	} else {
	            		swal(
				      		'Oops!',
				      		'Something went wrong sending the e-mail... Try again later!',
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
<div class=" container-fluid   container-fixed-lg">
    <div class="row">
		<div class="col-lg-12">
		<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
					<div class="card-title">Gebruikers</div>
					<div class="tools">
						<a class="collapse" href="javascript:;"></a>
						<a class="config" data-toggle="modal" href="#grid-config"></a>
						<a class="reload" href="javascript:;"></a>
						<a class="remove" href="javascript:;"></a>
					</div>
				    <div class="pull-right">
				    	<div class="col-xs-12">
				    		<input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
				    	</div>
				    </div>
				    <div class="clearfix"></div>
				</div>
				<div class="card-block">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="condensedTable" data-table-count="10">
						<thead>
							<tr>
								<th style="width:10%">ID</th>
								<th style="width:20%">Naam</th>
								<th style="width:25%">Email</th>
								<th style="width:20%">Rechten</th>
								<th style="width:30%">Acties</th>
							</tr>
						</thead>
							<tbody>
								@foreach($users as $user)
								<tr class="user_line" data-id="{{ $user->id }}">
									<td class="v-align-middle">{{ $user->id }}</td>
							    	<td class="v-align-middle semi-bold">{{ $user->name }}</td>
							    	<td class="v-align-middle">{{ $user->email }}</td>
							    	<td class="v-align-middle">
							    		@if($user->active)
							    			<i class="fa fa-check"></i>
							    		@else
							    			<i class="fa fa-times-circle"></i>
							    		@endif
							    		@foreach($user->getRoleNames() as $role)
											<span class="label label-success">{{$role}}</span>
										@endforeach
							    	</td>
							    	<td class="v-align-middle semi-bold">
							    		@can('edit users')
							    		<a href="{{ route('dashboard.users.edit', ['user' => $user->id]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i data-feather="edit-2"></i> edit
							    		</a>
							    		@endcan
							    		@can('delete users')
							    		<a href="#" onclick="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm btn-rounded m-r-20 user_delete" data-id="{{ $user->id }}">
							    			<i data-feather="trash-2"></i> 
							    		</a>
							    		@endcan
							    		@can('edit users')
							    		<a href="#" onclick="resendInvitationUser({{ $user->id }})" class="btn btn-secondary btn-sm btn-rounded m-r-20 user_resend" data-id="{{ $user->id }}">
							    			<i data-feather="refresh-ccw"></i> 
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


@include('chuckcms::backend.users._modal')
@endsection