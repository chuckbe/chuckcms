@extends('chuckcms::backend.layouts.base')

@section('content')
<div class="container p-3">
  <div class="row">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.users.roles') }}">Rollen</a></li>
                <li class="breadcrumb-item active" aria-current="Rollen">Bewerk rol "{{ $role->name }}"</li>
            </ol>
        </nav>
    </div>
  </div>
  <form action="{{ route('dashboard.users.roles.save') }}" method="POST">
    <div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
      <div class="col-sm-12">
        <div class="my-3">
          <div class="form-group form-group-default required ">
            <label>Naam</label>
            <input type="text" class="form-control" placeholder="Naam" id="role_name" name="role_name" value="{{ $role->name }}" required>
          </div>
          <div class="form-group form-group-default required ">
            <label>Redirect</label>
            <input type="text" class="form-control" placeholder="Redirect" id="role_redirect" name="role_redirect" value="{{ $role->redirect }}" required>
          </div>
        </div>
      </div>

      <div class="js_field_container_wrapper my-3 col-sm-12">
        @foreach($permissions as $permission)
          <div class="row field-input-group js_field_row_container">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group form-group-default input-group">
                    <div class="form-input-group">
                      <label class="inline">{{ $permission->name }}</label>
                    </div>
                    <div class="input-group-addon bg-transparent h-c-50 mx-3">
                      <input type="hidden" name="permissions_name[]" value="{{ $permission->name }}" required>
                      <input type="hidden" name="permissions_active[{{ $loop->index }}]" value="0">
                      <input type="checkbox" data-init-plugin="switchery" data-size="small" data-color="primary" value="1" name="permissions_active[{{ $loop->index }}]" @if($role->hasPermissionTo($permission->name)) checked @endif />
                    </div>
                  </div>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 my-3">
        <p class="pull-right">
          <input type="hidden" name="role_id" value="{{ $role->id }}">
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          <button type="submit" name="update" class="btn btn-success btn-cons pull-right m-1" value="1">Opslaan</button>
          <a href="{{ route('dashboard.users.roles') }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
        </p>
      </div>
    </div>
  </form>
</div>


@endsection

@section('css')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script>
		$( document ).ready(function() { 
			$("#page_title").keyup(function(){
			    var text = $(this).val();
			    slug_text = text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
			    $("#page_slug").val(slug_text);
          $("#page_slug_hidden").val(slug_text);  
			});

			$(".selectable").select2();

		});
	</script>
@endsection