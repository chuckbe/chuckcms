@extends('chuckcms::backend.layouts.admin')

@section('content')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg">

<!-- START card -->
<form action="{{ route('dashboard.page.save') }}" method="POST">
<div class="card card-transparent">
  <div class="card-header ">
    <div class="card-title">Bewerk gebruiker "{{ $user->name }}"
    </div>
  </div>
  <div class="card-block">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-transparent">
          
          <div class="col-lg-12">
            <div class="form-group form-group-default required ">
              <label>Naam</label>
              <input type="text" class="form-control" placeholder="Naam" id="user_name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group form-group-default required ">
              <label>Email</label>
              <input type="email" class="form-control" placeholder="Email" id="user_email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group form-group-default required ">
              <label>Gebruikersrollen</label>
              <select class="full-width" data-init-plugin="select2" multiple name="roles">
  							@foreach($roles as $role)
  								<option value="{{ $role->id }}" @if($user->hasRole($role->name)) selected @endif> {{ $role->name }}</option>
  							@endforeach
  						</select>
            </div>
          </div>
              
          <br>
          <p class="pull-right">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" name="update" class="btn btn-success btn-cons pull-right" value="1">Opslaan</button>
            <a href="{{ route('dashboard.users') }}" class="pull-right"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END card -->
</form>
</div>
<!-- END CONTAINER FLUID -->


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