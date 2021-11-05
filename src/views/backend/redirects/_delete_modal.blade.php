<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="deleteRedirectModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ben je zeker dat je de volgende <span class="semi-bold">redirect</span> wil verwijderen?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="p-b-10"><span id="delete_redirect_slug"></span> &rarr; <span id="delete_redirect_to"></span></p>
        <form role="form" method="POST" action="{{ route('dashboard.redirects.delete') }}">
          <div class="row">
            <div class="col text-right">
              <input type="hidden" id="delete_redirect_id" name="id" value="">
              <input type="hidden" name="_token" value="{{ Session::token() }}">
              <button type="submit" class="btn btn-danger ml-auto">Verwijderen</button>
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