@extends('chuckcms::backend.layouts.base')

@section('content')
<!-- START CONTAINER  -->
<div class="container p-3 min-height">
  <div class="row">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.users') }}">Gebruikers</a></li>
                <li class="breadcrumb-item active" aria-current="Gebruikers">Bewerk gebruiker "{{ $user->name }}"</li>
            </ol>
        </nav>
    </div>
  </div>
  <form action="{{ route('dashboard.page.save') }}" method="POST">
    <div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
      <div class="col-sm-12">
        <div class="my-3">
           <div class="form-group form-group-default required ">
              <label>Naam</label>
              <input type="text" class="form-control" placeholder="Naam" id="user_name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group form-group-default required ">
              <label>Email</label>
              <input type="email" class="form-control" placeholder="Email" id="user_email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group form-group-default required ">
              <label>Gebruikersrollen</label><br>
              <select class="full-width mt-2 selectable w-100" data-init-plugin="select2" multiple name="roles">
  							@foreach($roles as $role)
  								<option value="{{ $role->id }}" @if($user->hasRole($role->name)) selected @endif> {{ $role->name }}</option>
  							@endforeach
  						</select>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="my-3">
          <p class="pull-right">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" name="update" class="btn btn-success btn-cons pull-right m-1" value="1">Opslaan</button>
            <a href="{{ route('dashboard.users') }}" class="pull-right m-1"><button type="button" class="btn btn-info btn-cons">Annuleren</button></a>
          </p>
        </div>
      </div>
    </div>
  </form>
</div>
<!-- END CONTAINER  -->


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