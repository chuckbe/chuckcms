<!-- Modal -->
<div class="modal fade stick-up disable-scroll" id="createPagesModal" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog ">
  <div class="modal-content-wrapper">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Maak een nieuw <span class="semi-bold">Pagina</span> aan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="p-b-10">Vul de volgende velden aan om het pagina aan te maken.</p>
        @if($errors->any())
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        @endif
        <form role="form" method="POST" action="{{ route('dashboard.page.createmodal') }}">
          <div class="form-group-attached">
            <div class="row">
              <div class="col-md-12 py-0">
                <div class="form-group form-group-default required">
                  <label>Slug</label>
                  <input type="text" id="create_pages_slug" name="slug" class="form-control no-special-but-hyphens" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 py-0">
                <div class="form-group form-group-default required">
                  <label>Title</label>
                  <input type="text" id="create_pages_title" name="title" class="form-control no-special-but-hyphens" required>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12 py-0">
                    <div class="form-group form-group-default required">
                        <label>Pagina</label>
                        <select class="form-control" name="page">
                            <option value="" selected >Standaard</option>
                            @foreach($pageViews as $template => $view)
                                <optgroup label="Template: '{{ $template }}'">
                                    @foreach($view['files'] as $file)
                                        <option value="{{ $view['hintpath'] . '::templates.' . $template . '.' . $file }}">{{ $file }} - {{ $template }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
          </div>
        <div class="row">
        <div class="col-6">
            <div class="form-group form-group-default input-group ">
                <label for="isHp">
                    <input type="hidden" name="isHp" value="0">
                    <input type="checkbox" value="1" name="isHp" id="isHp" @if($page->isHp == 1) checked="checked" @endif />
                    Is dit de homepage?
                </label>
            </div>
        </div>
          <div class="col-6 text-right">
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