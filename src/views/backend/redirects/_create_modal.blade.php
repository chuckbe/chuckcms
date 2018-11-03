<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="createRedirectModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header clearfix text-left">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
        </button>
        <h5>Maak een nieuwe <span class="semi-bold">redirect</span> aan</h5>
        <p class="p-b-10">Vul de volgende velden aan om de redirect aan te maken.</p>
        @if($errors->any())
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        @endif
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="{{ route('dashboard.redirects.create') }}">
          <div class="form-group-attached">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Van</label>
                  <input type="text" id="create_redirect_slug" name="slug" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Naar</label>
                  <input type="text" name="to" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default form-group-default-select2 required">
                  <label class="">Type</label>
                  <select class="full-width" name="type" data-placeholder="Selecteer type" data-minimum-results-for-search="-1" data-init-plugin="select2" required>
                      <option value="301">301 - Permanent</option>
                      <option value="302">302 - Tijdelijk</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col-md-4 m-t-10 sm-m-t-10 pull-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" class="btn btn-primary btn-block m-t-5">Aanmaken</button>
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