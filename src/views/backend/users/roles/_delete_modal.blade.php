<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="deleteRoleModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header clearfix text-left">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
        </button>
        <h5>Ben je zeker dat je de volgende <span class="semi-bold">rol</span> wil verwijderen?</h5>
        <small><b>Dit kan onvoorziene gevolgen hebben voor de installatie van ChuckCMS. Als je niet weet waarmee je bezig bent, klik deze pop-up dan weg.</b></small>
        <p class="p-b-10 p-t-10">Rol: <span id="delete_role_name"></span> <br> Redirect: &rarr; <span id="delete_role_redirect"></span></p>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="{{ route('dashboard.users.roles.delete') }}">
          <div class="row">
            <div class="col-md-12 m-t-10 sm-m-t-10 pull-right">
              <input type="hidden" id="delete_role_id" name="role_id" value="">
              <input type="hidden" name="_token" value="{{ Session::token() }}">
              <button type="submit" class="btn btn-danger btn-block m-t-5">Verwijderen</button>
              <button type="button" class="btn btn-secondary btn-block m-t-5 pull-right" data-dismiss="modal" aria-hidden="true">Annuleren</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
</div>
<!-- /.modal-dialog -->