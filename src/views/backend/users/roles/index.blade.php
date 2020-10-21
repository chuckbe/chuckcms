@extends('chuckcms::backend.layouts.base')

@section('title')
  Rollen & Rechten
@endsection

@section('add_record')
  @can('create roles')
  <a href="#" data-target="#createRoleModal" data-toggle="modal" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Rol Toe</a>
  @endcan
@endsection

@section('content')
<div class="container p-3">
  <div class="row">
    <div class="col-sm-12">
			<nav aria-label="breadcrumb">
        <ol class="breadcrumb mt-3">
          <li class="breadcrumb-item active" aria-current="Rollen">Rollen</li>
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
    <div class="col-sm-12 my-3">
      <div class="table-responsive">
        <table class="table" data-datatable style="width:100%">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Naam</th>
              <th scope="col">Redirect</th>
              <th scope="col" style="min-width:170px">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
              <tr>
                <td>{{ $role->id }}</td>
                <td class="semi-bold">{{ $role->name }}</td>
                <td>{{$role->redirect }}</td>
                <td class="semi-bold">
                  @can('edit roles')
                    <a href="{{ route('dashboard.users.roles.edit', ['role' => $role->id]) }}" class="btn btn-sm btn-outline-secondary rounded d-inline-block">
                      <i class="fa fa-edit"></i> edit
                    </a>
                  @endcan
                  @can('delete roles')
                    <a href="#" onclick="deleteModal({{ $role->id }}, '{{ $role->name }}', '{{ $role->redirect }}')" class="btn btn-danger btn-sm btn-rounded m-r-20">
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
@can('create roles')
  @include('chuckcms::backend.users.roles._create_modal')
@endcan
@can('delete roles')
  @include('chuckcms::backend.users.roles._delete_modal')
@endcan
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
    <script type="text/javascript">
    function deleteModal(id, name, redirect){
      $('#delete_role_id').val(id);
      $('#delete_role_name').text(name);
      $('#delete_role_redirect').text(redirect);
      $('#deleteRoleModal').modal('show');
    }
    </script>
    @if (session('notification'))
      @include('chuckcms::backend.includes.notification')
    @endif
    @if (session('whoops'))
      @include('chuckcms::backend.includes.whoops')
    @endif
@endsection

