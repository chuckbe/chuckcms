<div id="modal_link_editor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Bewerken:</h4>
      	</div>
      	<div class="modal-body">
      		<div class="form-group">
      			<label for="link">Link Value</label>
            <textarea id="link_edit_value" cols="30" rows="10" class="form-control link_edit_value"></textarea>
      			<input type="hidden" class="link_edit_element">
	        </div>

	        <div class="form-group">
	        	<label for="href">URL</label>
      			<input class="form-control link_edit_href_value" id="link_edit_href_value">
	        </div>

	        <div class="form-group">
	        	<label for="href">CLASS</label>
      			<input class="form-control link_edit_class_value" id="link_edit_class_value">
	        </div>

	        <div class="form-group">
	        	<label for="href">STYLE</label>
      			<input class="form-control link_edit_style_value" id="link_edit_style_value">
	        </div>

          <div class="form-group">
            <label for="href">TARGET</label>
            <input class="form-control link_edit_target_value" id="link_edit_target_value">
          </div>

      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" id="edit_link_btn">Bewerken</button>
      	</div>
    </div>
  </div>
</div>