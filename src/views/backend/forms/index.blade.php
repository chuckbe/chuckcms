@extends('chuckcms::backend.layouts.base')

@section('title')
	Formulieren
@endsection

@section('add_record')
@can('create forms')

<a href="#" data-target="#createFormModal" data-toggle="modal" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuw Formulier Toe</a>
@endcan
@endsection

@section('content')
<div class="container p-3 min-height">
	<div class="row">
		<div class="col-sm-12">
			<nav aria-label="breadcrumb">
        		<ol class="breadcrumb mt-3">
          			<li class="breadcrumb-item active" aria-current="Formulieren">Formulieren</li>
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
		@can('create forms')
			<div class="col-sm-12 text-right">
				<a href="#" data-target="#createFormModal" data-toggle="modal" class="btn btn-sm btn-outline-success">Voeg Nieuw Formulier Toe</a>
			</div>
		@endcan
		<div class="col-sm-12 my-3">
			<div class="table-responsive">
				<table class="table" data-datatable style="width:100%">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Titel</th>
							<th scope="col">Slug</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($forms as $form)
							<tr class="form_line" data-id="{{ $form->id}}">
								<td>{{ $form->id }}</td>
								<td class="semi-bold">{{ $form->title }}</td>
								<td>{{ $form->slug }}</td>
								<td class="semi-bold">
									@can('edit forms')
							    		<a href="{{ route('dashboard.forms.edit', ['slug' => $form->slug]) }}" class="btn btn-sm btn-outline-secondary rounded d-inline-block">
							    			<i class="fa fa-edit"></i> edit
							    		</a>
							    	@endcan
							    	@can('show formentries')
							    		<a href="{{ route('dashboard.forms.entries', ['slug' => $form->slug]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
							    			<i class="fa fa-clipboard"></i> entries
							    		</a>
							    	@endcan
									@can('delete forms')
							    		<a href="#" class="btn btn-danger btn-sm btn-rounded m-r-20 form_delete" data-id="{{ $form->id }}">
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

@can('create forms')
@include('chuckcms::backend.forms._create_modal')
@endcan
@endsection

@section('scripts')
    <script src="https://cdn.chuck.be/assets/plugins/sweetalert2.all.js"></script>
    <script>
    $(document).ready(function() {

    	$(".no-special-but-hyphens").keyup(function(){
		    var text = $(this).val();
		    slug_text = text.toLowerCase().replace(/[^A-Za-z-]/g, "").replace(/ +/g,'-');
		    $(this).val(slug_text);  
		});

    });

    $( document ).ready(function (){
    	$('.form_delete').each(function(){
			var form_id = $(this).attr("data-id");
			var token = '{{ Session::token() }}';
		  	$(this).click(function (event) {
		  		event.preventDefault();
		  		swal({
					title: 'Are you sure?',
					text: "This will also delete all of the form entries. You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
				  	if (result.value) { 
				  		$.ajax({
	                        method: 'POST',
	                        url: "{{ route('dashboard.forms.delete') }}",
	                        data: { 
	                        	form_id: form_id, 
	                        	_token: token
	                        }
	                    })
	                    .done(function (data) {
	                    	if(data == 'success'){
	                    		$(".form_line[data-id='"+form_id+"']").first().remove();
	                    		swal(
						      		'Deleted!',
						      		'The form and its entries has been deleted.',
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
		    });
		});
    });

    </script>
@endsection

