<div id="modal_image_editor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Wijzig afbeelding:</h4>
      	</div>
      	<div class="modal-body">
      		<div class="form-group">
      			<div class="input-group">
					<span class="input-group-btn">
						<a id="lfm" data-input="edit_image_value" data-preview="holder" class="btn btn-primary lfm_input">
							<i class="fa fa-camera"></i> Kies
						</a>
					</span>
					<input class="form-control edit_image_value" id="edit_image_value" type="text" name="filepath">
	        		<input type="hidden" class="edit_image_element" name="edit_element">
				</div>
				<img id="holder" style="margin-top:15px;max-height:100px;">
	        </div>
	        <div class="form-group">
	        	<label for="alt">Alt Tekst</label>
	        	<input type="text" class="form-control edit_image_alt_value" name="alt_value">
	        </div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" id="edit_image_btn">Bewerken</button>
      	</div>
    </div>
  </div>
</div>