@extends('chuckcms::templates.' . $template->slug . '.layouts.builder')

@section('content')
<div class="container">
    <div class="row">
        <a id="add_block_top" style="border:none;">
            <div class="panel panel-default mb-none">
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
	            		<a href="" class="btn btn-sm btn-danger pb_control_delete" data-id="{{ $pageblock['id'] }}">
	            			<i class="fa fa-trash"></i>
	            		</a>
		            		<a href="" class="btn btn-sm btn-default pb_control_move_down" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-caret-down"></i>
		            		</a>
		            		<a href="" class="btn btn-sm btn-default pb_control_move_up" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-caret-up"></i>
		            		</a>
	            		<a href="" class="btn btn-sm btn-primary pb_control_edit" data-id="{{ $pageblock['id'] }}">
	            			<i class="fa fa-file-code"></i>
	            		</a>
	            		<a href="" class="btn btn-sm btn-success pb_control_save" data-id="{{ $pageblock['id'] }}">
	            			<i class="fa fa-check"></i>
	            		</a>
	            	</div>
	            	<div id="ace_editor_{{ $pageblock['id'] }}" class="ace_editor_height_null">
	            	</div>
	            	<div class="pageblock_body" id="pageblock_body_{{ $pageblock['id'] }}">
	            		{!! $pageblock['body'] !!}
	            	</div>
	            	<div class="pageblock_body_raw" id="pageblock_body_raw_{{ $pageblock['id'] }}">
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
									<div class="col-sm-3">
										
									</div>
									<div class="col-sm-3">
										
									</div>
									<div class="col-sm-3">
										
									</div>
									<div class="col-sm-3">
										
									</div>
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
	        	<input type="text" class="form-control edit_value" name="edit_value">
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
	.pb_element_text_hover{
		-webkit-box-shadow: 0px 0px 0px 6px rgba(255,0,0,1)!important;
		-moz-box-shadow: 0px 0px 0px 6px rgba(255,0,0,1)!important;
		box-shadow: 0px 0px 0px 6px rgba(255,0,0,1)!important;
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
    $(".pageblock_body_container[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
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
    $(".pageblock_body_container[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_down[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    $(".pb_control_move_up[data-id='"+pb_id+"']").attr("data-order", pb_order_target);
    					console.log(pb_order);
			  			init();
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
			    $('.pageblock_body h1').hover(
				       function(){ $(this).addClass('pb_element_text_hover') },
				       function(){ $(this).removeClass('pb_element_text_hover') }
				);

				$('.pageblock_body h1').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('input.edit_value').val(content);
				        $('#modal_text_editor').modal('show')
				    });
				});

				$('.pageblock_body h2').hover(
				       function(){ $(this).addClass('pb_element_text_hover') },
				       function(){ $(this).removeClass('pb_element_text_hover') }
				);

				$('.pageblock_body h2').each(function(){
					var content = $(this).text();
				  	$(this).click(function (event) {
				  		$('input.edit_value').val(content);
				        $('#modal_text_editor').modal('show')
				    });
				});
			}
			    
		});
	</script>
@endsection