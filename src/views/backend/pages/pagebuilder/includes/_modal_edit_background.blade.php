<div id="modal_background_editor" class="modal fade" role="dialog">
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
						<a id="lfm" data-input="edit_background_value" data-preview="backgroundholder" class="btn btn-primary lfm_input">
							<i class="fa fa-camera"></i> Kies
						</a>
					</span>
					<input id="edit_background_value" class="form-control edit_background_value" type="text" name="filepath">
	        		<input type="hidden" class="edit_background_element">
				</div>
				<img id="backgroundholder" style="margin-top:15px;max-height:100px;">
	        </div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" id="edit_background_btn">Bewerken</button>
      	</div>
    </div>
  </div>
</div>