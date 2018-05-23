@extends('chuckcms::backend.layouts.pagebuilder')

@section('content')
<div class="container">
    <div class="row">
        <a id="add_block_top" style="border:none;color:dodgerblue;">
            <div class="panel panel-default mb-none" style="background:#ececec;border:dashed dodgerblue 4px;">
                <div class="panel-body text-center">
					<h3>PAGINA BLOCK TOEVOEGEN</h3>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="container pageblock_container" style="background:#FFF;">
	<div class="row">
		@if($pageblocks !== null)
	        @foreach($pageblocks as $pageblock)
	            <div class="pageblock_body_container" id="pageblock-{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}" data-id="{{ $pageblock['id'] }}">
	            	<div class="pageblock_overlay not_shown" id="pageblock_overlay_{{ $pageblock['id'] }}"></div>
	            	<div id="pb_controls">
	            		@can('edit pagebuilder')
		            		<a href="" class="btn btn-sm btn-danger pb_control_delete" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-trash"></i>
		            		</a>
		            		<a href="" class="btn btn-sm btn-default pb_control_move_down" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-caret-down"></i>
		            		</a>
		            		<a href="" class="btn btn-sm btn-default pb_control_move_up" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-caret-up"></i>
		            		</a>
		            	@endcan
		            	@can('code pagebuilder')
		            		<a href="" class="btn btn-sm btn-primary pb_control_edit" data-id="{{ $pageblock['id'] }}">
		            			<i class="fa fa-file-code"></i>
		            		</a>
		            		<a href="" class="btn btn-sm btn-success pb_control_save_code not_shown" data-id="{{ $pageblock['id'] }}">
		            			<i class="fa fa-check"></i>
		            		</a>
	            		@endcan
	            		@can('edit pagebuilder')
		            		<a href="" class="btn btn-sm btn-success pb_control_save" data-id="{{ $pageblock['id'] }}">
		            			<i class="fa fa-check"></i>
		            		</a>
	            		@endcan
	            	</div>
	            	<div id="ace_editor_{{ $pageblock['id'] }}" class="ace_editor_height_null">
	            	</div>
	            	<div class="pageblock_body" id="pageblock_body_{{ $pageblock['id'] }}" data-pbid="{{ $pageblock['id'] }}">
	            		{!! $pageblock['body'] !!}
	            	</div>
	            	<div class="pageblock_body_raw" id="pageblock_body_raw_{{ $pageblock['id'] }}" data-pbid="{{ $pageblock['id'] }}">
	            		{!! $pageblock['raw'] !!}
	            	</div>
	            </div>
			@endforeach
	    @endif
	</div>
</div>

<div class="container">
    <div class="row">
        <a id="add_block_bottom">
            <div class="panel panel-default">
                <div class="panel-body text-center">
					<h3>PAGINA BLOCK TOEVOEGEN</h3>
                </div>
            </div>
        </a>
    </div>
</div>
			
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
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#collapse1">Sliders & Headers</a>
							</h4>
						</div>
						<div id="collapse1" class="panel-collapse collapse">
							<div class="panel-body">Panel Body</div>
							<div class="panel-footer">Panel Footer</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#collapse2">Content</a>
							</h4>
						</div>
						<div id="collapse2" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="col-sm-12">
									@foreach($blocks as $block)
									<div class="col-sm-3">
										<a class="pb_add_block_top_button" data-location="{{ $block['location'] }}" data-name="{{ $block['name'] }}">
											<img src="{{ URL::to($block['img']) }}" class="img-responsive" alt="{{ $block['name'] }}">
											<p class="text-center">{{ $block['name'] }}</p>
										</a>
									</div>
									@endforeach
								</div>
							</div>
							<div class="panel-footer">Panel Footer</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#collapse3">CTA's</a>
							</h4>
						</div>
						<div id="collapse3" class="panel-collapse collapse">
							<div class="panel-body">Panel Body</div>
							<div class="panel-footer">Panel Footer</div>
						</div>
					</div>
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
	        </div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
        	<button type="button" class="btn btn-success" data-dismiss="modal">Bewerken</button>
      	</div>
    </div>
  </div>
</div>

@endsection

@section('css')
<style>
.not_shown{
	display:none;
}
.shown{
	display:inherit;
}
.ace_editor_height_null{height:0px;visibility:hidden;}
.ace_editor_height_full{height:250px;visibility: visible;}
.pageblock_container .btn {
  border-radius: 0 !important;
}

.pageblock_body_container{
	position: relative;
	display:table;
	width: 100%;
}

.pageblock_overlay{
	position: relative;
	display:table;
	width: 100%;
	z-index: 98;
	background-color: rgba(255, 0, 0, 0.6);
}

#pb_controls{
	position: absolute;
	right: 0;
	z-index: 99;
}

.pageblock_body_raw{
	display:none;
}
	.pb_element_title_hover{
		-webkit-box-shadow: 0px 0px 0px 6px rgba(255,0,0,1)!important;
		-moz-box-shadow: 0px 0px 0px 6px rgba(255,0,0,1)!important;
		box-shadow: 0px 0px 0px 6px rgba(255,0,0,1)!important;
		cursor: pointer!important;
	}

	.pb_element_text_hover{
		-webkit-box-shadow: 0px 0px 0px 2px rgba(255,0,0,1)!important;
		-moz-box-shadow: 0px 0px 0px 2px rgba(255,0,0,1)!important;
		box-shadow: 0px 0px 0px 2px rgba(255,0,0,1)!important;
		cursor: pointer!important;
	}

</style>
@endsection

@section('scripts')
	<script src="{{ URL::to('chuckbe/chuckcms/js/plugins/sweetalert2.all.js') }}"></script>
	<script src="{{ URL::to('chuckbe/chuckcms/js/plugins/ace/ace.js') }}"></script>
	<script>
		$( document ).ready(function() {
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
				$('#add_block_top').click(function (event) {
			        $('#modal_add_block_top').modal('show')
			    });

			    $('#add_block_bottom').click(function (event) {
			        $('#modal_add_block_bottom').modal('show')
			    });


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
			}
			    
		});
	</script>
@endsection