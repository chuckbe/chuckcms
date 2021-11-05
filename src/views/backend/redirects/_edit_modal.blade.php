<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="editRedirectModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Bewerk de volgende <span class="semi-bold">redirect</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="p-b-10">Bewerk de volgende velden aan om de redirect aan te wijzigen.</p>
        <form role="form" method="POST" action="{{ route('dashboard.redirects.update') }}">
          <div class="form-group-attached">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Van</label>
                  <input type="text" id="edit_redirect_slug" name="slug" class="form-control no-special-but-hyphens" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Naar</label>
                  <input type="text" id="edit_redirect_to" name="to" class="form-control no-special-but-hyphens" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default form-group-default-select2 required">
                  <label class="">Type</label>
                  <select class="form-control" id="edit_redirect_type" name="type" required>
                      <option value="301">301 - Permanent</option>
                      <option value="302">302 - Tijdelijk</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col text-right">
            <input type="hidden" id="edit_redirect_id" name="id" value="">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" class="btn btn-primary btn-block m-t-5">Bewerken</button>
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