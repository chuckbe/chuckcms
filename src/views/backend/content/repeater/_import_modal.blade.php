<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="importRepeaterModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header clearfix text-left">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
        </button>
        <h5>Importeer een nieuwe <span class="semi-bold">repeater</span> via JSON</h5>
        <p class="p-b-10">Upload de JSON file om de repeater aan te maken.</p>
        @if($errors->any())
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        @endif
      </div>
      <div class="modal-body">
        <form role="form" method="POST" action="{{ route('dashboard.content.repeaters.import') }}" enctype="multipart/form-data">
          <div class="form-group-attached">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Upload JSON bestand</label>
                  <input type="file" name="file" class="form-control no-special-but-hyphens" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Slug</label>
                  <input type="text" name="slug" class="form-control no-special-but-hyphens" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 m-t-10 sm-m-t-10 pull-right">
              <input type="hidden" name="_token" value="{{ Session::token() }}">
              <button type="submit" class="btn btn-primary btn-block m-t-5">Importeren</button>
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