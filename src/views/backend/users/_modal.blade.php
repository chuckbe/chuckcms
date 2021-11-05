<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="newUserModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nodig een nieuwe <span class="semi-bold">gebruiker</span> uit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p class="p-b-10">Volgende informatie hebben we nodig om de gebruiker uit te nodigen.</p>
        <form role="form" method="POST" action="{{ route('dashboard.users.invite') }}">
          <div class="form-group-attached">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Naam</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>E-mailadres</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default form-group-default-select2 required">
                  <label class="">Rechten</label>
                  <select class="form-control" name="role" required>
                    @foreach($roles as $role)
                      @if($role->name == 'super-admin')
                      @hasrole('super-admin')
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                      @endhasrole
                      @else
                      <option value="{{ $role->name }}">{{ $role->name }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col text-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" class="btn btn-primary">Uitnodigen</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
</div>
<style>
  .select2-dropdown {z-index:9999;}
</style>
<!-- /.modal-dialog -->