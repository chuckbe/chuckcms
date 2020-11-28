<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="importRepeaterModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Importeer een nieuwe <b>repeater</b> via JSON</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Upload de JSON file om de repeater aan te maken.</p>
        @if($errors->any())
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        @endif
        <form role="form" method="POST" action="{{ route('dashboard.content.repeaters.import') }}" enctype="multipart/form-data">
          <div class="form-group-attached">
            <div class="row">
              <div class="col-md-12 px-3">
                <div class="form-group">
                  <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="repeaterJsonImportFile" required>
                    <label class="custom-file-label" for="repeaterJsonImportFile">Upload JSON bestand *</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
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