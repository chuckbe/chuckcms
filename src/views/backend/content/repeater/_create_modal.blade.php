<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="createRepeaterModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Maak een nieuw <span class="semi-bold">Repeater</span> aan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="p-b-10">Vul de volgende velden aan om het repeater aan te maken.</p>
        @if($errors->any())
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        @endif
        <form role="form" method="POST" action="{{ route('dashboard.content.repeaters.createModal') }}">
          <div class="form-group-attached">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Slug</label>
                  <input type="text" id="create_form_slug" name="content_slug" class="form-control no-special-but-hyphens" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-default required">
                  <label>Type Content</label>
                  {{-- <input type="text" id="create_form_title" name="title" class="form-control no-special-but-hyphens" required> --}}
                    <select name="content_type" id="type_content" class="full-width select2 form-control" data-init-plugin="select2" name="content_type" data-minimum-results-for-search="-1">
                        <option value="repeater" selected>Repeater</option>
                        <option value="module">Module</option>
                    </select>
                </div>
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col-12 text-right">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit" class="btn btn-primary m-t-5">Aanmaken</button>
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