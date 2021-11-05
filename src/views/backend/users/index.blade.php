@extends('chuckcms::backend.layouts.base')

@section('title')
	Gebruikers
@endsection

@section('add_record')
	@can('create users')
	<a href="#" data-target="#newUserModal" data-toggle="modal" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Gebruiker Toe</a>
	@endcan
@endsection

@section('content')
<div class="container p-3 min-height">
	<div class="row">
		<div class="col-sm-12">
			<nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active" aria-current="Gebruiker">Gebruikers</li>
                </ol>
            </nav>
		</div>
	</div>
	<div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<a class="config" data-toggle="modal" href="#grid-config"></a>
			<a class="reload" href="javascript:;"></a>
			<a class="remove" href="javascript:;"></a>
		</div>
		@can('create users')
		<div class="col-sm-12 text-right">
    		<a href="#" data-target="#newUserModal" data-toggle="modal" class="btn btn-sm btn-outline-success">Voeg Gebruiker Toe</a>
    	</div>
		@endcan
		<div class="col-sm-12 my-3">
			<div class="table-responsive">
				<table class="table" data-datatable style="width:100%">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Naam</th>
							<th scope="col">Email</th>
							<th scope="col">Rechten</th>
							<th scope="col" style="min-width:170px">Acties</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr class="user_line" data-id="{{ $user->id }}">
								<td>{{ $user->id }}</td>
								<td class="semi-bold">{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>
									@if($user->active)
							    			<i class="fa fa-check"></i>
							    		@else
							    			<i class="fa fa-times-circle"></i>
							    	@endif
									@foreach($user->getRoleNames() as $role)
											<span class="label label-success">{{$role}}</span>
									@endforeach
								</td>
								<td>
									@can('edit users')
							    		<a href="{{ route('dashboard.users.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-outline-secondary rounded d-inline-block">
							    			<i class="fa fa-edit"></i> edit
							    		</a>
							    		@endcan
							    		@can('delete users')
							    		<a href="#" class="btn btn-danger btn-sm btn-rounded m-r-20 user_delete" data-id="{{ $user->id }}">
							    			<i class="fa fa-trash"></i> 
							    		</a>
							    		@endcan
							    		@can('edit users')
							    		<a href="#" 
										{{-- onclick="resendInvitationUser({{ $user->id }})"  --}}
										class="btn btn-secondary btn-sm btn-rounded m-r-20 user_resend" data-id="{{ $user->id }}">
							    			<i class="fa fa-refresh"></i>
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


@include('chuckcms::backend.users._modal')
@endsection

@section('css')

@endsection

@section('scripts')
@if (session('notification'))
@include('chuckcms::backend.includes.notification')
@endif
<script src="https://cdn.chuck.be/assets/plugins/sweetalert2.all.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.user_delete').each(function(){
		let user_id = $(this).attr('data-id');
		let token = '{{ Session::token() }}';
		$(this).click(function(event){
			event.preventDefault();
			swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result)=>{
				if(result.value == true) {
					$.ajax({
		                method: 'POST',
		                url: "{{ route('dashboard.user.delete') }}",
		                data: { 
		                	user_id: user_id, 
		                	_token: token
		                }
		            })
					.done(function(data){
						if(data == 'success'){
							$(".user_line[data-id='"+user_id+"']").first().remove();
							swal(
					      		'Deleted!',
					      		'The user has been deleted.',
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
					//done ends here
				}
			})
			
		})
	}); // user delete function ends here

	$('.user_resend').each(function(){
		let user_id = $(this).attr('data-id');
		let token = '{{ Session::token() }}';
		$(this).click(function(event){
			event.preventDefault();
			swal({
			title: 'Resend invitation e-mail?',
			text: "The user will be able to reset their password!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, send it!'
			}).then((result)=>{
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
						if(data == 'success') {
							//@TODO:deactivate user > change icon
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
					})
				}
			})
		});
	});// user resend invitation ends here
});
</script>
@endsection

