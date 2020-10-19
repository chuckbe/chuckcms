@extends('chuckcms::backend.layouts.base')

@section('title')
  Rollen & Rechten
@endsection

@section('add_record')
  @can('create roles')
  <a href="#" data-target="#createRoleModal" data-toggle="modal" class="btn btn-link text-primary m-l-20 hidden-md-down">Voeg Nieuwe Rol Toe</a>
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

@section('content')
<div class=" container-fluid   container-fixed-lg">
<div class="container p-3">
    <div class="row">
    <div class="col-lg-12">
    <!-- START card -->
      <div class="card card-transparent">
        <div class="card-header ">
          <div class="card-title">Rollen</div>
          <div class="tools">
            <a class="collapse" href="javascript:;"></a>
            <a class="config" data-toggle="modal" href="#grid-config"></a>
            <a class="reload" href="javascript:;"></a>
            <a class="remove" href="javascript:;"></a>
          </div>
        </div>
        <div class="card-block">
          <div class="table-responsive">
            <table class="table table-hover table-condensed" id="condensedTable" data-table-count="6">
            <thead>
              <tr>
                <th style="width:5%">ID</th>
                <th style="width:20%">Naam</th>
                <th style="width:35%">Redirect</th>
                <th style="width:25%">Actions</th>
              </tr>
            </thead>
              <tbody>
                @foreach($roles as $role)
                <tr>
                  <td class="v-align-middle">{{ $role->id }}</td>
                    <td class="v-align-middle semi-bold">{{ $role->name }}</td>
                    <td class="v-align-middle">{{$role->redirect }}</td>
                    <td class="v-align-middle semi-bold">
                      @can('edit roles')
                      <a href="{{ route('dashboard.users.roles.edit', ['role' => $role->id]) }}" class="btn btn-default btn-sm btn-rounded m-r-20">
                        <i data-feather="edit-2"></i> edit
                      </a>
                      @endcan

                      @can('delete roles')
                      <a href="#" onclick="deleteModal({{ $role->id }}, '{{ $role->name }}', '{{ $role->redirect }}')" class="btn btn-danger btn-sm btn-rounded m-r-20">
                        <i data-feather="trash"></i> delete
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
</div>
@can('create roles')
  @include('chuckcms::backend.users.roles._create_modal')
@endcan
@can('delete roles')
  @include('chuckcms::backend.users.roles._delete_modal')
@endcan
@endsection