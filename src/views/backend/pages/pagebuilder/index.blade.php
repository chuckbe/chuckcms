@extends('chuckcms::backend.layouts.pagebuilder')

@section('content')


<iframe src="{{ route('dashboard.page.raw', ['page_id' => $page->id]) }}" frameborder="0" style="width:90%;height:80vh;margin-left:5%;" id="pagebuilder_iframe"></iframe>

{{-- ALL OF THE MODALS --}}        

<div id="modal_add_block_top" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Voeg Pagina Block Toe:</h4>
      	</div>
      	<div class="modal-body">
      		<form action="">
      			<div class="panel-group">
      				@foreach($blocks as $bKey => $bValue)
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#{{ $bKey }}" style="text-transform:capitalize">{{ str_replace('-', ' ', $bKey) }}</a>
							</h4>
						</div>
						<div id="{{ $bKey }}" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="col-sm-12">
									@foreach($bValue as $block)
									<div class="col-sm-3">
										<a class="pb_add_block_top_button" data-location="{{ $block['location'] }}" data-name="{{ $block['name'] }}">
											<img src="{{ URL::to($block['img']) }}" class="img-responsive text-center" alt="{{ $block['name'] }}" style="margin:0 auto 0 auto;">
											<p class="text-center">{{ $block['name'] }}</p>
										</a>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
      		</form>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" data-dismiss="modal">Toevoegen</button>
      	</div>
    </div>

  </div>
</div>

<div id="modal_add_block_bottom" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Voeg Pagina Block Toe:</h4>
      	</div>
      	<div class="modal-body">
      		<form action="">
      			<div class="form-group">
		        	<input type="text" class="form-control edit_value" name="edit_value">
		        </div>
      		</form>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" data-dismiss="modal">Toevoegen</button>
      	</div>
    </div>

  </div>
</div>
{{-- EDIT MODALS --}}
<div id="modal_title_editor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Bewerken:</h4>
      	</div>
      	<div class="modal-body">
      		<div class="form-group">
	        	<input type="text" class="form-control edit_value" id="edit_title_value" name="edit_value">
	        	<input type="hidden" class="edit_element" name="edit_element">
	        </div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" id="edit_title_btn">Bewerken</button>
      	</div>
    </div>
  </div>
</div>

<div id="modal_text_editor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Bewerken:</h4>
      	</div>
      	<div class="modal-body">
      		<div class="form-group">
      			<textarea class="form-control edit_value" id="text_edit_value" name="edit_value" rows="10"></textarea>
      			<input type="hidden" class="text_edit_element" name="edit_element">
	        </div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" id="edit_text_btn">Bewerken</button>
      	</div>
    </div>
  </div>
</div>

<div id="modal_code_editor" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:90%;margin-left:5%;">
    <!-- Modal content-->
    <div class="modal-content" style="display:block;">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">HTML:</h4>
      	</div>
      	<div class="modal-body">
      		<div class="form-group" style="position:relative;height:250px;">
      			<div id="ace_editor" style="position: absolute;width: 100%;height: 250px;"></div>
	        </div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" id="edit_code_btn">Bewerken</button>
      	</div>
    </div>
  </div>
</div>

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
						<a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
							<i class="fa fa-camera"></i> Kies
						</a>
					</span>
					<input id="thumbnail" class="form-control edit_image_value" id="edit_image_value" type="text" name="filepath">
	        		<input type="hidden" class="edit_image_element" name="edit_element">
				</div>
				<img id="holder" style="margin-top:15px;max-height:100px;">
	        </div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" id="edit_image_btn">Bewerken</button>
      	</div>
    </div>
  </div>
</div>

@endsection

@section('css')
<style>
	body {
		overscroll-behavior-x: none;
	}
</style>
@endsection

@section('scripts')
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script src="https://cdn.chuck.be/assets/plugins/sweetalert2.all.js"></script>
	<script src="https://cdn.chuck.be/assets/plugins/ace/ace.js"></script>
	 <script src="{{ URL::to('vendor/laravel-filemanager/js/lfm.js') }}"></script>
	<script>

	$('#pagebuilder_iframe').on('load', function(){

        var iframe = $('#pagebuilder_iframe').contents();
		init();
		var token = '{{ Session::token() }}';

	    function init () {
			//init media manager inputs 
			var domain = "{{ URL::to('dashboard/media')}}";
			$('#lfm').filemanager('image', {prefix: domain});

			//init add block buttons for modals
			iframe.find('#add_block_top').click(function (event) {
		        $('#modal_add_block_top').modal('show')
		    });
		    iframe.find('#add_block_bottom').click(function (event) {
		        $('#modal_add_block_bottom').modal('show')
		    });

		    //remove first and last block's 'move-up' and 'move-down' buttons
			var first_order = iframe.find('.pageblock_body_container:first-child').attr('data-order');
			var last_order = iframe.find('.pageblock_body_container:last-child').attr('data-order');
			iframe.find('.pageblock_body_container .pb_control_move_down').each(function(){	
				 	$(this).removeClass('hidden');
				 	if( $(this).attr('data-order') == last_order ) {
				 		$(this).addClass('hidden');
				 	}
			});
			iframe.find('.pageblock_body_container .pb_control_move_up').each(function(){
				 	$(this).removeClass('hidden');
				 	if( $(this).attr('data-order') == first_order ) {
				 		$(this).addClass('hidden');
				 	}
			});

			// EDIT INSIDE PAGEBLOCK HTML THROUGH MODAL FORMS
		    iframe.find('.pageblock_body [data-content="title"]').hover(
			       function(){ $(this).addClass('pb_element_title_hover') },
			       function(){ $(this).removeClass('pb_element_title_hover') }
			);

			iframe.find('.pageblock_body [data-content="title"]').each(function(){
				var content = $(this).text();
			  	$(this).click(function (event) {
			  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
					$(this).attr('data-unique', el);
					var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
					$(this).attr('data-pbid', pbid);
					var eltype = $(this).prop('nodeName');
					var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
					iframe.find("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			  		$('input.edit_value').val(content);
			  		$('input.edit_element').val(el);
			  		$('input.edit_element').attr('data-pbid', pbid);
			        $('#modal_title_editor').modal('show');
			    });
			});

			$('#edit_title_btn').click(function (event) {
				var el = $('input.edit_element').val();
				var content = $('#edit_title_value').val();
				var pbid = $('input.edit_element').attr('data-pbid');
				//console.log('el :', el, ' - content :', content);
				replaceContent(el, content);
				iframe.find('.pb_control_save[data-id='+pbid+']').removeClass('not_shown');
				iframe.find('.pb_control_save[data-id='+pbid+']').addClass('shown');
				$('#modal_title_editor').modal('hide');
			});

			function replaceContent (el, content) {
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").html(content);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").html(content);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
			}

			// iframe.find('.pageblock_body h2[data-content="title"]').hover(
			//        function(){ $(this).addClass('pb_element_title_hover') },
			//        function(){ $(this).removeClass('pb_element_title_hover') }
			// );

			// iframe.find('.pageblock_body h2[data-content="title"]').each(function(){
			// 	var content = $(this).text();
			//   	$(this).click(function (event) {
			//   		$('input.edit_value').val(content);
			//         $('#modal_title_editor').modal('show');
			//     });
			// });

			// iframe.find('.pageblock_body h3[data-content="title"]').hover(
			//        function(){ $(this).addClass('pb_element_title_hover') },
			//        function(){ $(this).removeClass('pb_element_title_hover') }
			// );

			// iframe.find('.pageblock_body h3[data-content="title"]').each(function(){
			// 	var content = $(this).text();
			//   	$(this).click(function (event) {
			//   		$('input.edit_value').val(content);
			//         $('#modal_title_editor').modal('show');
			//     });
			// });

			// iframe.find('.pageblock_body h4[data-content="title"]').hover(
			//        function(){ $(this).addClass('pb_element_title_hover') },
			//        function(){ $(this).removeClass('pb_element_title_hover') }
			// );

			// iframe.find('.pageblock_body h4[data-content="title"]').each(function(){
			// 	var content = $(this).text();
			//   	$(this).click(function (event) {
			//   		$('input.edit_value').val(content);
			//         $('#modal_title_editor').modal('show');
			//     });
			// });

			// iframe.find('.pageblock_body h5[data-content="title"]').hover(
			//        function(){ $(this).addClass('pb_element_title_hover') },
			//        function(){ $(this).removeClass('pb_element_title_hover') }
			// );

			// iframe.find('.pageblock_body h5[data-content="title"]').each(function(){
			// 	var content = $(this).text();
			//   	$(this).click(function (event) {
			//   		$('input.edit_value').val(content);
			//         $('#modal_title_editor').modal('show');
			//     });
			// });

			// iframe.find('.pageblock_body h6[data-content="title"]').hover(
			//        function(){ $(this).addClass('pb_element_title_hover') },
			//        function(){ $(this).removeClass('pb_element_title_hover') }
			// );

			// iframe.find('.pageblock_body h6[data-content="title"]').each(function(){
			// 	var content = $(this).text();
			//   	$(this).click(function (event) {
			//   		$('input.edit_value').val(content);
			//         $('#modal_title_editor').modal('show');
			//     });
			// });

			// iframe.find('.pageblock_body p[data-content="title"]').hover(
			//        function(){ $(this).addClass('pb_element_text_hover') },
			//        function(){ $(this).removeClass('pb_element_text_hover') }
			// );
			// iframe.find('.pageblock_body p[data-content="title"]').each(function(){
			// 	var content = $(this).text();
			//   	$(this).click(function (event) {
			//   		$('#text_edit_value').val(content);
			//         $('#modal_title_editor').modal('show');
			//     });
			// });

			iframe.find('.pageblock_body [data-content="text"]').hover(
			       function(){ $(this).addClass('pb_element_text_hover') },
			       function(){ $(this).removeClass('pb_element_text_hover') }
			);
			iframe.find('.pageblock_body [data-content="text"]').each(function(){
				var content = $(this).text();
			  	$(this).click(function (event) {
			  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
					$(this).attr('data-unique', el);
					var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
					$(this).attr('data-pbid', pbid);
					var eltype = $(this).prop('nodeName');
					var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
					iframe.find("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			  		$('#text_edit_value').val(content);
			  		$('input.text_edit_element').val(el);
			  		$('input.text_edit_element').attr('data-pbid', pbid);
			        $('#modal_text_editor').modal('show');
			    });
			});
			$('#edit_text_btn').click(function (event) {
				var el = $('input.text_edit_element').val();
				var content = $('#text_edit_value').val();
				var pbid = $('input.text_edit_element').attr('data-pbid');
				replaceContent(el, content);
				iframe.find('.pb_control_save[data-id='+pbid+']').removeClass('not_shown');
				iframe.find('.pb_control_save[data-id='+pbid+']').addClass('shown');
				$('#modal_text_editor').modal('hide');
			});




			iframe.find('.pageblock_body img[data-type="image"]').each(function(){
				var content = $(this).attr('src');
			  	$(this).click(function (event) {
			  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
					$(this).attr('data-unique', el);
					var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
					$(this).attr('data-pbid', pbid);
					var eltype = $(this).prop('nodeName');
					var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
					$("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			  		$('input.edit_image_value').val(content);
			  		$('input.edit_image_element').val(el);
			  		$('img#holder').attr('src', content);
			        $('#modal_image_editor').modal('show');
			    });
			});
		}



		/* PB CONTROLS SECTION */
			iframe.find('.pageblock_body_container .pb_control_delete').each(function(){
				var pb_id = $(this).attr("data-id");
				var pb_order = $(this).attr("data-order");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		swal({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  	if (result.value) {
					  		/* AJAX FOR DELETE HERE */
					  		iframe.find('#pageblock_overlay_'+pb_id).removeClass('not_shown');
					  		iframe.find('#pageblock_overlay_'+pb_id).addClass('shown');   
					  		$.ajax({
		                        method: 'POST',
		                        url: "{{ route('api.pageblock.delete') }}",
		                        data: { 
		                        	pageblock_id: pb_id, 
		                        	_token: token
		                        }
		                    })
		                    .done(function (data) {
		                    	console.log('data :: ', data);
		                    	// if data == success ?
		                    	console.log('done + pb_order :: ', pb_order);
		                        iframe.find('.pageblock_body_container').each(function(){
		                        	if($(this).attr('data-order') > pb_order){
		                        		var old_order = Number($(this).attr('data-order'));
		                        		var new_order = (Number($(this).attr('data-order')) - 1);

		                        		console.log('old_order fst :: ', old_order, 'new_order fst :: ', new_order);
		                        		iframe.find(".pageblock_body_container #pb_controls a[data-order='"+old_order+"']").each(function(){
		                        			console.log('inside the a loop :: ', old_order, new_order);
		                        			$(this).attr('data-order', new_order);
		                        		});
		                        		$(this).attr('data-order', new_order); 
		                        	}
		                        });
		                        iframe.find(".pageblock_body_container[data-order='"+pb_order+"']").first().remove();
					  			init();
		                    });
					    	swal(
					      		'Deleted!',
					      		'Your file has been deleted.',
					      		'success'
					    	)
					  	}
					})
			    });
			});
			iframe.find('.pageblock_body_container .pb_control_edit').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		//iframe.find('.pb_control_save_code').removeClass('not_shown');
			  		//iframe.find('.pb_control_save').addClass('not_shown');
			  		var pb_html = iframe.find('#pageblock_body_raw_'+pb_id).html();
			  		//console.log('the pb html : ', pb_html);
			  		//iframe.find('#pageblock_body_'+pb_id).addClass('not_shown');
			  		//iframe.find('#ace_editor_'+pb_id).removeClass('ace_editor_height_null');
			  		//iframe.find('#ace_editor_'+pb_id).addClass('ace_editor_height_full');
			  		
			  		//fix this shit
			        
			  		var editor = ace.edit('ace_editor');
				    editor.setTheme("ace/theme/monokai");
				    editor.session.setMode("ace/mode/html");
				    editor.setValue(pb_html);
				    $('#edit_code_btn').attr('data-id', pb_id);
				    $('#modal_code_editor').modal('show');
			    });
			});

			iframe.find('.pageblock_body_container .pb_control_save').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		$(this).removeClass('shown');
			  		$(this).addClass('not_shown');
			  		iframe.find('#pageblock_overlay_'+pb_id).removeClass('not_shown');
			  		iframe.find('#pageblock_overlay_'+pb_id).addClass('shown');   
					var pb_html = iframe.find('#pageblock_body_raw_'+pb_id).html();
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.update') }}",
                        data: { 
                        	pageblock_id: pb_id, 
                        	html: pb_html, 
                        	_token: token
                        }
                    })
                    .done(function (data) {
                        iframe.find('#pageblock_body_raw_'+pb_id).html(data.raw);
                        var pb_html = iframe.find('#pageblock_body_raw_'+pb_id).html();
                        //var editor = ace.edit('ace_editor_'+pb_id); 
                        //editor.setValue(data.raw);
                        iframe.find('#pageblock_body_'+pb_id).html(data.body);
                        iframe.find('#pageblock_overlay_'+pb_id).removeClass('shown');
			  			iframe.find('#pageblock_overlay_'+pb_id).addClass('not_shown');
			  			iframe.find('#pageblock_body_'+pb_id).removeClass('not_shown');
			  			init();
                    });
			    });
			});

			$('#edit_code_btn').click(function (event) {
				event.preventDefault();
				var pb_id = $(this).attr("data-id");
				iframe.find('#pageblock_overlay_'+pb_id).removeClass('not_shown');
			  	iframe.find('#pageblock_overlay_'+pb_id).addClass('shown');

			  	var editor = ace.edit('ace_editor');    
				var pb_html = editor.session.getValue();
		  		$.ajax({
                    method: 'POST',
                    url: "{{ route('api.pageblock.update') }}",
                    data: { 
                    	pageblock_id: pb_id, 
                    	html: pb_html, 
                    	_token: token
                    }
                })
                .done(function (data) {
                    iframe.find('#pageblock_body_raw_'+pb_id).html(data.raw);
                    var pb_html = iframe.find('#pageblock_body_raw_'+pb_id).html();
                    iframe.find('#pageblock_body_'+pb_id).html(data.body);
                    iframe.find('#pageblock_overlay_'+pb_id).removeClass('shown');
		  			iframe.find('#pageblock_overlay_'+pb_id).addClass('not_shown');
		  			//iframe.find('#ace_editor_'+pb_id).removeClass('ace_editor_height_full');
		  			//iframe.find('#ace_editor_'+pb_id).addClass('ace_editor_height_null');
		  			//iframe.find('#pageblock_body_'+pb_id).removeClass('not_shown');
		  			//iframe.find('.pb_control_save_code').addClass('not_shown');
		  			//iframe.find('.pb_control_save').removeClass('not_shown');
		  			init();
                });

				$('#modal_code_editor').modal('hide');
			});

			// iframe.find('.pageblock_body_container .pb_control_save_code').each(function(){
			// 	var pb_id = $(this).attr("data-id");
			//   	$(this).click(function (event) {
			//   		event.preventDefault();
			//   		iframe.find('#pageblock_overlay_'+pb_id).removeClass('not_shown');
			//   		iframe.find('#pageblock_overlay_'+pb_id).addClass('shown');
			//   		var editor = ace.edit('ace_editor_'+pb_id);    
			// 		var pb_html = editor.session.getValue();
			//   		$.ajax({
   	//                      method: 'POST',
   	//                      url: "{{ route('api.pageblock.update') }}",
   	//                      data: { 
   	//                      	pageblock_id: pb_id, 
   	//                      	html: pb_html, 
   	//                      	_token: token
   	//                      }
   	//                  })
   	//                  .done(function (data) {
   	//                      iframe.find('#pageblock_body_raw_'+pb_id).html(data.raw);
   	//                      var pb_html = iframe.find('#pageblock_body_raw_'+pb_id).html();
   	//                      var editor = ace.edit('ace_editor_'+pb_id); 
   	//                      editor.setValue(data.raw);
   	//                      iframe.find('#pageblock_body_'+pb_id).html(data.body);
   	//                      iframe.find('#pageblock_overlay_'+pb_id).removeClass('shown');
			//   			iframe.find('#pageblock_overlay_'+pb_id).addClass('not_shown');
			//   			iframe.find('#ace_editor_'+pb_id).removeClass('ace_editor_height_full');
			//   			iframe.find('#ace_editor_'+pb_id).addClass('ace_editor_height_null');
			//   			iframe.find('#pageblock_body_'+pb_id).removeClass('not_shown');
			//   			iframe.find('.pb_control_save_code').addClass('not_shown');
			//   			iframe.find('.pb_control_save').removeClass('not_shown');
			//   			init();
   //                  });
			//     });
			// });
			iframe.find('.pageblock_body_container .pb_control_move_up').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
					var pb_order = iframe.find(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order");
					var pb_order_target = Number(pb_order) - 1;
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.move_up') }}",
                        data: { 
                        	pageblock_id: pb_id,  
                        	_token: token
                        }
                    })
                    .done(function (data) {
    iframe.find(".pageblock_body_container[data-order='"+pb_order+"']").detach().insertBefore(iframe.find(".pageblock_body_container[data-order='"+pb_order_target+"']"));

    iframe.find(".pageblock_body_container[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pb_control_move_down[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pb_control_move_up[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pb_control_delete[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pageblock_body_container[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    iframe.find(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    iframe.find(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    iframe.find(".pb_control_delete[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
			  			init();
                    });
			    });
			});
			
			iframe.find('.pageblock_body_container .pb_control_move_down').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
					var pb_order = iframe.find(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order");
					var pb_order_target = Number(pb_order) + 1;
			  		console.log(pb_order);
			  		console.log(pb_order_target);
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.move_down') }}",
                        data: { 
                        	pageblock_id: pb_id,  
                        	_token: token
                        }
                    })
                    .done(function (data) {
    iframe.find(".pageblock_body_container[data-order='"+pb_order_target+"']").detach().insertBefore(iframe.find(".pageblock_body_container[data-order='"+pb_order+"']"));

    iframe.find(".pageblock_body_container[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pb_control_move_down[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pb_control_move_up[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pb_control_delete[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    iframe.find(".pageblock_body_container[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    iframe.find(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    iframe.find(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    iframe.find(".pb_control_delete[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    					console.log(pb_order);
			  			init();
                    });
			    });
			});

			iframe.find('.pb_add_block_top_button').each(function(){
				var pb_name = $(this).attr("data-name");
				var pb_location = $(this).attr("data-location");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.add_block_top') }}",
                        data: { 
                        	name: pb_name,
                        	location: pb_location, 
                        	page_id: "{{ $page->id }}", 
                        	_token: token
                        }
                    })
                    .done(function (data) {
                    	document.location = document.location.href;
                    });
			    });
			});




	});



		$( document ).ready(function() {

			

// LINE LINE LINE LINE LINE LINE LINE LINE LINE LINE //
			init();
			var token = '{{ Session::token() }}';
			/* PB CONTROLS SECTION */
			$('.pageblock_body_container .pb_control_delete').each(function(){
				var pb_id = $(this).attr("data-id");
				var pb_order = $(this).attr("data-order");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		swal({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  	if (result.value) {
					  		/* AJAX FOR DELETE HERE */
					  		$('#pageblock_overlay_'+pb_id).removeClass('not_shown');
					  		$('#pageblock_overlay_'+pb_id).addClass('shown');   
					  		$.ajax({
		                        method: 'POST',
		                        url: "{{ route('api.pageblock.delete') }}",
		                        data: { 
		                        	pageblock_id: pb_id, 
		                        	_token: token
		                        }
		                    })
		                    .done(function (data) {
		                    	console.log('data :: ', data);
		                    	// if data == success ?
		                    	console.log('done + pb_order :: ', pb_order);
		                        $('.pageblock_body_container').each(function(){
		                        	if($(this).attr('data-order') > pb_order){
		                        		var old_order = Number($(this).attr('data-order'));
		                        		var new_order = (Number($(this).attr('data-order')) - 1);

		                        		console.log('old_order fst :: ', old_order, 'new_order fst :: ', new_order);
		                        		$(".pageblock_body_container #pb_controls a[data-order='"+old_order+"']").each(function(){
		                        			console.log('inside the a loop :: ', old_order, new_order);
		                        			$(this).attr('data-order', new_order);
		                        		});
		                        		$(this).attr('data-order', new_order); 
		                        	}
		                        });
		                        $(".pageblock_body_container[data-order='"+pb_order+"']").first().remove();
					  			init();
		                    });
					    	swal(
					      		'Deleted!',
					      		'Your file has been deleted.',
					      		'success'
					    	)
					  	}
					})
			    });
			});
			$('.pageblock_body_container .pb_control_edit').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		$('.pb_control_save_code').removeClass('not_shown');
			  		$('.pb_control_save').addClass('not_shown');
			  		var pb_html = $('#pageblock_body_raw_'+pb_id).html();
			  		console.log('the pb html : ', pb_html);
			  		$('#pageblock_body_'+pb_id).addClass('not_shown');
			  		$('#ace_editor_'+pb_id).removeClass('ace_editor_height_null');
			  		$('#ace_editor_'+pb_id).addClass('ace_editor_height_full');
			  		var editor = ace.edit('ace_editor_'+pb_id);
				    editor.setTheme("ace/theme/monokai");
				    editor.session.setMode("ace/mode/html");
				    editor.setValue(pb_html);
			    });
			});

			$('.pageblock_body_container .pb_control_save').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		$('#pageblock_overlay_'+pb_id).removeClass('not_shown');
			  		$('#pageblock_overlay_'+pb_id).addClass('shown');   
					var pb_html = $('#pageblock_body_raw_'+pb_id).html();
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.update') }}",
                        data: { 
                        	pageblock_id: pb_id, 
                        	html: pb_html, 
                        	_token: token
                        }
                    })
                    .done(function (data) {
                        $('#pageblock_body_raw_'+pb_id).html(data.raw);
                        var pb_html = $('#pageblock_body_raw_'+pb_id).html();
                        var editor = ace.edit('ace_editor_'+pb_id); 
                        editor.setValue(data.raw);
                        $('#pageblock_body_'+pb_id).html(data.body);
                        $('#pageblock_overlay_'+pb_id).removeClass('shown');
			  			$('#pageblock_overlay_'+pb_id).addClass('not_shown');
			  			$('#pageblock_body_'+pb_id).removeClass('not_shown');
			  			init();
                    });
			    });
			});

			$('.pageblock_body_container .pb_control_save_code').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		$('#pageblock_overlay_'+pb_id).removeClass('not_shown');
			  		$('#pageblock_overlay_'+pb_id).addClass('shown');
			  		var editor = ace.edit('ace_editor_'+pb_id);    
					var pb_html = editor.session.getValue();
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.update') }}",
                        data: { 
                        	pageblock_id: pb_id, 
                        	html: pb_html, 
                        	_token: token
                        }
                    })
                    .done(function (data) {
                        $('#pageblock_body_raw_'+pb_id).html(data.raw);
                        var pb_html = $('#pageblock_body_raw_'+pb_id).html();
                        var editor = ace.edit('ace_editor_'+pb_id); 
                        editor.setValue(data.raw);
                        $('#pageblock_body_'+pb_id).html(data.body);
                        $('#pageblock_overlay_'+pb_id).removeClass('shown');
			  			$('#pageblock_overlay_'+pb_id).addClass('not_shown');
			  			$('#ace_editor_'+pb_id).removeClass('ace_editor_height_full');
			  			$('#ace_editor_'+pb_id).addClass('ace_editor_height_null');
			  			$('#pageblock_body_'+pb_id).removeClass('not_shown');
			  			$('.pb_control_save_code').addClass('not_shown');
			  			$('.pb_control_save').removeClass('not_shown');
			  			init();
                    });
			    });
			});
			$('.pageblock_body_container .pb_control_move_up').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
					var pb_order = $(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order");
					var pb_order_target = Number(pb_order) - 1;
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.move_up') }}",
                        data: { 
                        	pageblock_id: pb_id,  
                        	_token: token
                        }
                    })
                    .done(function (data) {
    $(".pageblock_body_container[data-order='"+pb_order+"']").detach().insertBefore(".pageblock_body_container[data-order='"+pb_order_target+"']");

    $(".pageblock_body_container[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pb_control_move_down[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pb_control_move_up[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pb_control_delete[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pageblock_body_container[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_delete[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
			  			init();
                    });
			    });
			});
			
			$('.pageblock_body_container .pb_control_move_down').each(function(){
				var pb_id = $(this).attr("data-id");
			  	$(this).click(function (event) {
			  		event.preventDefault();
					var pb_order = $(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order");
					var pb_order_target = Number(pb_order) + 1;
			  		console.log(pb_order);
			  		console.log(pb_order_target);
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.move_down') }}",
                        data: { 
                        	pageblock_id: pb_id,  
                        	_token: token
                        }
                    })
                    .done(function (data) {
    $(".pageblock_body_container[data-order='"+pb_order_target+"']").detach().insertBefore(".pageblock_body_container[data-order='"+pb_order+"']");

    $(".pageblock_body_container[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pb_control_move_down[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pb_control_move_up[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pb_control_delete[data-order='"+pb_order_target+"']").attr("data-order", pb_order);
    $(".pageblock_body_container[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_delete[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    					console.log(pb_order);
			  			init();
                    });
			    });
			});

			$('.pb_add_block_top_button').each(function(){
				var pb_name = $(this).attr("data-name");
				var pb_location = $(this).attr("data-location");
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		$.ajax({
                        method: 'POST',
                        url: "{{ route('api.pageblock.add_block_top') }}",
                        data: { 
                        	name: pb_name,
                        	location: pb_location, 
                        	page_id: "{{ $page->id }}", 
                        	_token: token
                        }
                    })
                    .done(function (data) {
                    	document.location = document.location.href;
                    });
			    });
			});

				

			function init () {
				//init media manager inputs 
				var domain = "{{ URL::to('dashboard/media')}}";
				$('#lfm').filemanager('image', {prefix: domain});

				//init add block buttons for modals
				$('#add_block_top').click(function (event) {
			        $('#modal_add_block_top').modal('show')
			    });
			    $('#add_block_bottom').click(function (event) {
			        $('#modal_add_block_bottom').modal('show')
			    });

			    //remove first and last block's 'move-up' and 'move-down' buttons
				var first_order = $('.pageblock_body_container:first-child').attr('data-order');
				var last_order = $('.pageblock_body_container:last-child').attr('data-order');
				$('.pageblock_body_container .pb_control_move_down').each(function(){	
					 	$(this).removeClass('hidden');
					 	if( $(this).attr('data-order') == last_order ) {
					 		$(this).addClass('hidden');
					 	}
				});
				$('.pageblock_body_container .pb_control_move_up').each(function(){
					 	$(this).removeClass('hidden');
					 	if( $(this).attr('data-order') == first_order ) {
					 		$(this).addClass('hidden');
					 	}
				});

				// EDIT INSIDE PAGEBLOCK HTML THROUGH MODAL FORMS
			    $('.pageblock_body h1[data-content="title"]').hover(
				       function(){ $(this).addClass('pb_element_title_hover') },
				       function(){ $(this).removeClass('pb_element_title_hover') }
				);

				$('.pageblock_body h1[data-content="title"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
						$(this).attr('data-unique', el);
						var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
						$(this).attr('data-pbid', pbid);
						var eltype = $(this).prop('nodeName');
						var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
						$("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
				  		$('input.edit_value').val(content);
				  		$('input.edit_element').val(el);
				        $('#modal_title_editor').modal('show');
				    });
				});

				$('#edit_title_btn').click(function (event) {
					var el = $('input.edit_element').val();
					var content = $('#edit_title_value').val();
					console.log('el :', el, ' - content :', content);
					$('.pageblock_body').find("[data-unique='"+el+"']").html(content);
					$('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');
					$('.pageblock_body_raw').find("[data-unique='"+el+"']").html(content);
					$('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
					$('#modal_title_editor').modal('hide');
				});

				$('.pageblock_body h2[data-content="title"]').hover(
				       function(){ $(this).addClass('pb_element_title_hover') },
				       function(){ $(this).removeClass('pb_element_title_hover') }
				);

				$('.pageblock_body h2[data-content="title"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('input.edit_value').val(content);
				        $('#modal_title_editor').modal('show');
				    });
				});

				$('.pageblock_body h3[data-content="title"]').hover(
				       function(){ $(this).addClass('pb_element_title_hover') },
				       function(){ $(this).removeClass('pb_element_title_hover') }
				);

				$('.pageblock_body h3[data-content="title"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('input.edit_value').val(content);
				        $('#modal_title_editor').modal('show');
				    });
				});

				$('.pageblock_body h4[data-content="title"]').hover(
				       function(){ $(this).addClass('pb_element_title_hover') },
				       function(){ $(this).removeClass('pb_element_title_hover') }
				);

				$('.pageblock_body h4[data-content="title"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('input.edit_value').val(content);
				        $('#modal_title_editor').modal('show');
				    });
				});

				$('.pageblock_body h5[data-content="title"]').hover(
				       function(){ $(this).addClass('pb_element_title_hover') },
				       function(){ $(this).removeClass('pb_element_title_hover') }
				);

				$('.pageblock_body h5[data-content="title"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('input.edit_value').val(content);
				        $('#modal_title_editor').modal('show');
				    });
				});

				$('.pageblock_body h6[data-content="title"]').hover(
				       function(){ $(this).addClass('pb_element_title_hover') },
				       function(){ $(this).removeClass('pb_element_title_hover') }
				);

				$('.pageblock_body h6[data-content="title"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('input.edit_value').val(content);
				        $('#modal_title_editor').modal('show');
				    });
				});

				$('.pageblock_body p[data-content="title"]').hover(
				       function(){ $(this).addClass('pb_element_text_hover') },
				       function(){ $(this).removeClass('pb_element_text_hover') }
				);
				$('.pageblock_body p[data-content="title"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('#text_edit_value').val(content);
				        $('#modal_title_editor').modal('show');
				    });
				});

				$('.pageblock_body p[data-content="text"]').hover(
				       function(){ $(this).addClass('pb_element_text_hover') },
				       function(){ $(this).removeClass('pb_element_text_hover') }
				);
				$('.pageblock_body p[data-content="text"]').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
						console.log(content);
				  		$('#text_edit_value').html(content);
				        $('#modal_text_editor').modal('show');
				    });
				});


				$('.pageblock_body img[data-type="image"]').each(function(){
					var content = $(this).attr('src');
				  	$(this).click(function (event) {
				  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
						$(this).attr('data-unique', el);
						var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
						$(this).attr('data-pbid', pbid);
						var eltype = $(this).prop('nodeName');
						var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
						$("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
				  		$('input.edit_image_value').val(content);
				  		$('input.edit_image_element').val(el);
				  		$('img#holder').attr('src', content);
				        $('#modal_image_editor').modal('show');
				    });
				});
			}
			    
		});
	</script>
@endsection