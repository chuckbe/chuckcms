<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="deleteRoleModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ben je zeker dat je de volgende <span class="semi-bold">rol</span> wil verwijderen?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small><b>Dit kan onvoorziene gevolgen hebben voor de installatie van ChuckCMS. Als je niet weet waarmee je bezig bent, klik deze pop-up dan weg.</b></small>
        <p class="mt-3">Rol: <span id="delete_role_name"></span> <br> Redirect: /login &rarr; /<span id="delete_role_redirect"></span></p>
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