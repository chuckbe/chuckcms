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
	
@endsection

@section('scripts')
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
<div class="container p-3">
	<div class="row">
		<div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active" aria-current="Redirects">Redirects</li>
                </ol>
            </nav>
        </div>
	</div>
	<div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
		@can('create redirects')
			<div class="col-sm-12 text-right">
    			<a href="#" data-target="#createRedirectModal" data-toggle="modal" class="btn btn-sm btn-outline-success">Voeg Nieuwe Redirect Toe</a>
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
							<th scope="col">Van</th>
							<th scope="col">Naar</th>
							<th scope="col">Type</th>
							<th scope="col" style="min-width:170px">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($redirects as $redirect)
							<tr>
								<td>{{ $redirect->id }}</td>
								<td class="semi-bold">{{ $redirect->slug}}</td>
								<td>{{ $redirect->to}}</td>
								<td><span class="label label-success">{{ $redirect->type}}</span></td>
								<td>
									@can('edit redirects')
							    		<a href="#" onclick="editModal({{ $redirect->id }}, '{{ $redirect->slug }}', '{{ $redirect->to }}', {{ $redirect->type }} )" class="btn btn-secondary btn-sm btn-rounded">
							    			edit
							    		</a>
							    	@endcan

							    	@can('delete redirects')
							    		<a href="#" onclick="deleteModal({{ $redirect->id }}, '{{ $redirect->slug }}', '{{ $redirect->to }}')" class="btn btn-danger btn-sm btn-rounded">
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