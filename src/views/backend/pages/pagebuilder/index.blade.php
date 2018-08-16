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
                      <p class="text-center">{{ $block['name'] }}</p>
											<img src="{{ URL::to($block['img']) }}" class="img-responsive text-center" alt="{{ $block['name'] }}" style="margin:0 auto 0 auto;">
										</a>
									</div>
                  
                  @if($loop->iteration % 4 == 0)
                    <div class="clearfix"></div>
                    <br><br>
                  @endif
									
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

<div id="modal_faicon_editor" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Icon Picker</h4>
			</div>
			<div class="modal-body">
				<div>
					<ul class="icon-picker-list"><li><a data-class="fa fa-glass " data-index="0"><span class="fa fa-glass"></span> <span class="name-class">fa fa-glass</span></a></li><li><a data-class="fa fa-music " data-index="1"><span class="fa fa-music"></span> <span class="name-class">fa fa-music</span></a></li><li><a data-class="fa fa-search " data-index="2"><span class="fa fa-search"></span> <span class="name-class">fa fa-search</span></a></li><li><a data-class="fa fa-envelope-o " data-index="3"><span class="fa fa-envelope-o"></span> <span class="name-class">fa fa-envelope-o</span></a></li><li><a data-class="fa fa-heart " data-index="4"><span class="fa fa-heart"></span> <span class="name-class">fa fa-heart</span></a></li><li><a data-class="fa fa-star " data-index="5"><span class="fa fa-star"></span> <span class="name-class">fa fa-star</span></a></li><li><a data-class="fa fa-star-o " data-index="6"><span class="fa fa-star-o"></span> <span class="name-class">fa fa-star-o</span></a></li><li><a data-class="fa fa-user " data-index="7"><span class="fa fa-user"></span> <span class="name-class">fa fa-user</span></a></li><li><a data-class="fa fa-film " data-index="8"><span class="fa fa-film"></span> <span class="name-class">fa fa-film</span></a></li><li><a data-class="fa fa-th-large " data-index="9"><span class="fa fa-th-large"></span> <span class="name-class">fa fa-th-large</span></a></li><li><a data-class="fa fa-th " data-index="10"><span class="fa fa-th"></span> <span class="name-class">fa fa-th</span></a></li><li><a data-class="fa fa-th-list " data-index="11"><span class="fa fa-th-list"></span> <span class="name-class">fa fa-th-list</span></a></li><li><a data-class="fa fa-check " data-index="12"><span class="fa fa-check"></span> <span class="name-class">fa fa-check</span></a></li><li><a data-class="fa fa-times " data-index="13"><span class="fa fa-times"></span> <span class="name-class">fa fa-times</span></a></li><li><a data-class="fa fa-search-plus " data-index="14"><span class="fa fa-search-plus"></span> <span class="name-class">fa fa-search-plus</span></a></li><li><a data-class="fa fa-search-minus " data-index="15"><span class="fa fa-search-minus"></span> <span class="name-class">fa fa-search-minus</span></a></li><li><a data-class="fa fa-power-off " data-index="16"><span class="fa fa-power-off"></span> <span class="name-class">fa fa-power-off</span></a></li><li><a data-class="fa fa-signal " data-index="17"><span class="fa fa-signal"></span> <span class="name-class">fa fa-signal</span></a></li><li><a data-class="fa fa-cog " data-index="18"><span class="fa fa-cog"></span> <span class="name-class">fa fa-cog</span></a></li><li><a data-class="fa fa-trash-o " data-index="19"><span class="fa fa-trash-o"></span> <span class="name-class">fa fa-trash-o</span></a></li><li><a data-class="fa fa-home " data-index="20"><span class="fa fa-home"></span> <span class="name-class">fa fa-home</span></a></li><li><a data-class="fa fa-file-o " data-index="21"><span class="fa fa-file-o"></span> <span class="name-class">fa fa-file-o</span></a></li><li><a data-class="fa fa-clock-o " data-index="22"><span class="fa fa-clock-o"></span> <span class="name-class">fa fa-clock-o</span></a></li><li><a data-class="fa fa-road " data-index="23"><span class="fa fa-road"></span> <span class="name-class">fa fa-road</span></a></li><li><a data-class="fa fa-download " data-index="24"><span class="fa fa-download"></span> <span class="name-class">fa fa-download</span></a></li><li><a data-class="fa fa-arrow-circle-o-down " data-index="25"><span class="fa fa-arrow-circle-o-down"></span> <span class="name-class">fa fa-arrow-circle-o-down</span></a></li><li><a data-class="fa fa-arrow-circle-o-up " data-index="26"><span class="fa fa-arrow-circle-o-up"></span> <span class="name-class">fa fa-arrow-circle-o-up</span></a></li><li><a data-class="fa fa-inbox " data-index="27"><span class="fa fa-inbox"></span> <span class="name-class">fa fa-inbox</span></a></li><li><a data-class="fa fa-play-circle-o " data-index="28"><span class="fa fa-play-circle-o"></span> <span class="name-class">fa fa-play-circle-o</span></a></li><li><a data-class="fa fa-repeat " data-index="29"><span class="fa fa-repeat"></span> <span class="name-class">fa fa-repeat</span></a></li><li><a data-class="fa fa-refresh " data-index="30"><span class="fa fa-refresh"></span> <span class="name-class">fa fa-refresh</span></a></li><li><a data-class="fa fa-list-alt " data-index="31"><span class="fa fa-list-alt"></span> <span class="name-class">fa fa-list-alt</span></a></li><li><a data-class="fa fa-lock " data-index="32"><span class="fa fa-lock"></span> <span class="name-class">fa fa-lock</span></a></li><li><a data-class="fa fa-flag " data-index="33"><span class="fa fa-flag"></span> <span class="name-class">fa fa-flag</span></a></li><li><a data-class="fa fa-headphones " data-index="34"><span class="fa fa-headphones"></span> <span class="name-class">fa fa-headphones</span></a></li><li><a data-class="fa fa-volume-off " data-index="35"><span class="fa fa-volume-off"></span> <span class="name-class">fa fa-volume-off</span></a></li><li><a data-class="fa fa-volume-down " data-index="36"><span class="fa fa-volume-down"></span> <span class="name-class">fa fa-volume-down</span></a></li><li><a data-class="fa fa-volume-up " data-index="37"><span class="fa fa-volume-up"></span> <span class="name-class">fa fa-volume-up</span></a></li><li><a data-class="fa fa-qrcode " data-index="38"><span class="fa fa-qrcode"></span> <span class="name-class">fa fa-qrcode</span></a></li><li><a data-class="fa fa-barcode " data-index="39"><span class="fa fa-barcode"></span> <span class="name-class">fa fa-barcode</span></a></li><li><a data-class="fa fa-tag " data-index="40"><span class="fa fa-tag"></span> <span class="name-class">fa fa-tag</span></a></li><li><a data-class="fa fa-tags " data-index="41"><span class="fa fa-tags"></span> <span class="name-class">fa fa-tags</span></a></li><li><a data-class="fa fa-book " data-index="42"><span class="fa fa-book"></span> <span class="name-class">fa fa-book</span></a></li><li><a data-class="fa fa-bookmark " data-index="43"><span class="fa fa-bookmark"></span> <span class="name-class">fa fa-bookmark</span></a></li><li><a data-class="fa fa-print " data-index="44"><span class="fa fa-print"></span> <span class="name-class">fa fa-print</span></a></li><li><a data-class="fa fa-camera " data-index="45"><span class="fa fa-camera"></span> <span class="name-class">fa fa-camera</span></a></li><li><a data-class="fa fa-font " data-index="46"><span class="fa fa-font"></span> <span class="name-class">fa fa-font</span></a></li><li><a data-class="fa fa-bold " data-index="47"><span class="fa fa-bold"></span> <span class="name-class">fa fa-bold</span></a></li><li><a data-class="fa fa-italic " data-index="48"><span class="fa fa-italic"></span> <span class="name-class">fa fa-italic</span></a></li><li><a data-class="fa fa-text-height " data-index="49"><span class="fa fa-text-height"></span> <span class="name-class">fa fa-text-height</span></a></li><li><a data-class="fa fa-text-width " data-index="50"><span class="fa fa-text-width"></span> <span class="name-class">fa fa-text-width</span></a></li><li><a data-class="fa fa-align-left " data-index="51"><span class="fa fa-align-left"></span> <span class="name-class">fa fa-align-left</span></a></li><li><a data-class="fa fa-align-center " data-index="52"><span class="fa fa-align-center"></span> <span class="name-class">fa fa-align-center</span></a></li><li><a data-class="fa fa-align-right " data-index="53"><span class="fa fa-align-right"></span> <span class="name-class">fa fa-align-right</span></a></li><li><a data-class="fa fa-align-justify " data-index="54"><span class="fa fa-align-justify"></span> <span class="name-class">fa fa-align-justify</span></a></li><li><a data-class="fa fa-list " data-index="55"><span class="fa fa-list"></span> <span class="name-class">fa fa-list</span></a></li><li><a data-class="fa fa-outdent " data-index="56"><span class="fa fa-outdent"></span> <span class="name-class">fa fa-outdent</span></a></li><li><a data-class="fa fa-indent " data-index="57"><span class="fa fa-indent"></span> <span class="name-class">fa fa-indent</span></a></li><li><a data-class="fa fa-video-camera " data-index="58"><span class="fa fa-video-camera"></span> <span class="name-class">fa fa-video-camera</span></a></li><li><a data-class="fa fa-picture-o " data-index="59"><span class="fa fa-picture-o"></span> <span class="name-class">fa fa-picture-o</span></a></li><li><a data-class="fa fa-pencil " data-index="60"><span class="fa fa-pencil"></span> <span class="name-class">fa fa-pencil</span></a></li><li><a data-class="fa fa-map-marker " data-index="61"><span class="fa fa-map-marker"></span> <span class="name-class">fa fa-map-marker</span></a></li><li><a data-class="fa fa-adjust " data-index="62"><span class="fa fa-adjust"></span> <span class="name-class">fa fa-adjust</span></a></li><li><a data-class="fa fa-tint " data-index="63"><span class="fa fa-tint"></span> <span class="name-class">fa fa-tint</span></a></li><li><a data-class="fa fa-pencil-square-o " data-index="64"><span class="fa fa-pencil-square-o"></span> <span class="name-class">fa fa-pencil-square-o</span></a></li><li><a data-class="fa fa-share-square-o " data-index="65"><span class="fa fa-share-square-o"></span> <span class="name-class">fa fa-share-square-o</span></a></li><li><a data-class="fa fa-check-square-o " data-index="66"><span class="fa fa-check-square-o"></span> <span class="name-class">fa fa-check-square-o</span></a></li><li><a data-class="fa fa-arrows " data-index="67"><span class="fa fa-arrows"></span> <span class="name-class">fa fa-arrows</span></a></li><li><a data-class="fa fa-step-backward " data-index="68"><span class="fa fa-step-backward"></span> <span class="name-class">fa fa-step-backward</span></a></li><li><a data-class="fa fa-fast-backward " data-index="69"><span class="fa fa-fast-backward"></span> <span class="name-class">fa fa-fast-backward</span></a></li><li><a data-class="fa fa-backward " data-index="70"><span class="fa fa-backward"></span> <span class="name-class">fa fa-backward</span></a></li><li><a data-class="fa fa-play " data-index="71"><span class="fa fa-play"></span> <span class="name-class">fa fa-play</span></a></li><li><a data-class="fa fa-pause " data-index="72"><span class="fa fa-pause"></span> <span class="name-class">fa fa-pause</span></a></li><li><a data-class="fa fa-stop " data-index="73"><span class="fa fa-stop"></span> <span class="name-class">fa fa-stop</span></a></li><li><a data-class="fa fa-forward " data-index="74"><span class="fa fa-forward"></span> <span class="name-class">fa fa-forward</span></a></li><li><a data-class="fa fa-fast-forward " data-index="75"><span class="fa fa-fast-forward"></span> <span class="name-class">fa fa-fast-forward</span></a></li><li><a data-class="fa fa-step-forward " data-index="76"><span class="fa fa-step-forward"></span> <span class="name-class">fa fa-step-forward</span></a></li><li><a data-class="fa fa-eject " data-index="77"><span class="fa fa-eject"></span> <span class="name-class">fa fa-eject</span></a></li><li><a data-class="fa fa-chevron-left " data-index="78"><span class="fa fa-chevron-left"></span> <span class="name-class">fa fa-chevron-left</span></a></li><li><a data-class="fa fa-chevron-right " data-index="79"><span class="fa fa-chevron-right"></span> <span class="name-class">fa fa-chevron-right</span></a></li><li><a data-class="fa fa-plus-circle " data-index="80"><span class="fa fa-plus-circle"></span> <span class="name-class">fa fa-plus-circle</span></a></li><li><a data-class="fa fa-minus-circle " data-index="81"><span class="fa fa-minus-circle"></span> <span class="name-class">fa fa-minus-circle</span></a></li><li><a data-class="fa fa-times-circle " data-index="82"><span class="fa fa-times-circle"></span> <span class="name-class">fa fa-times-circle</span></a></li><li><a data-class="fa fa-check-circle " data-index="83"><span class="fa fa-check-circle"></span> <span class="name-class">fa fa-check-circle</span></a></li><li><a data-class="fa fa-question-circle " data-index="84"><span class="fa fa-question-circle"></span> <span class="name-class">fa fa-question-circle</span></a></li><li><a data-class="fa fa-info-circle " data-index="85"><span class="fa fa-info-circle"></span> <span class="name-class">fa fa-info-circle</span></a></li><li><a data-class="fa fa-crosshairs " data-index="86"><span class="fa fa-crosshairs"></span> <span class="name-class">fa fa-crosshairs</span></a></li><li><a data-class="fa fa-times-circle-o " data-index="87"><span class="fa fa-times-circle-o"></span> <span class="name-class">fa fa-times-circle-o</span></a></li><li><a data-class="fa fa-check-circle-o " data-index="88"><span class="fa fa-check-circle-o"></span> <span class="name-class">fa fa-check-circle-o</span></a></li><li><a data-class="fa fa-ban " data-index="89"><span class="fa fa-ban"></span> <span class="name-class">fa fa-ban</span></a></li><li><a data-class="fa fa-arrow-left " data-index="90"><span class="fa fa-arrow-left"></span> <span class="name-class">fa fa-arrow-left</span></a></li><li><a data-class="fa fa-arrow-right " data-index="91"><span class="fa fa-arrow-right"></span> <span class="name-class">fa fa-arrow-right</span></a></li><li><a data-class="fa fa-arrow-up " data-index="92"><span class="fa fa-arrow-up"></span> <span class="name-class">fa fa-arrow-up</span></a></li><li><a data-class="fa fa-arrow-down " data-index="93"><span class="fa fa-arrow-down"></span> <span class="name-class">fa fa-arrow-down</span></a></li><li><a data-class="fa fa-share " data-index="94"><span class="fa fa-share"></span> <span class="name-class">fa fa-share</span></a></li><li><a data-class="fa fa-expand " data-index="95"><span class="fa fa-expand"></span> <span class="name-class">fa fa-expand</span></a></li><li><a data-class="fa fa-compress " data-index="96"><span class="fa fa-compress"></span> <span class="name-class">fa fa-compress</span></a></li><li><a data-class="fa fa-plus " data-index="97"><span class="fa fa-plus"></span> <span class="name-class">fa fa-plus</span></a></li><li><a data-class="fa fa-minus " data-index="98"><span class="fa fa-minus"></span> <span class="name-class">fa fa-minus</span></a></li><li><a data-class="fa fa-asterisk " data-index="99"><span class="fa fa-asterisk"></span> <span class="name-class">fa fa-asterisk</span></a></li><li><a data-class="fa fa-exclamation-circle " data-index="100"><span class="fa fa-exclamation-circle"></span> <span class="name-class">fa fa-exclamation-circle</span></a></li><li><a data-class="fa fa-gift " data-index="101"><span class="fa fa-gift"></span> <span class="name-class">fa fa-gift</span></a></li><li><a data-class="fa fa-leaf " data-index="102"><span class="fa fa-leaf"></span> <span class="name-class">fa fa-leaf</span></a></li><li><a data-class="fa fa-fire " data-index="103"><span class="fa fa-fire"></span> <span class="name-class">fa fa-fire</span></a></li><li><a data-class="fa fa-eye " data-index="104"><span class="fa fa-eye"></span> <span class="name-class">fa fa-eye</span></a></li><li><a data-class="fa fa-eye-slash " data-index="105"><span class="fa fa-eye-slash"></span> <span class="name-class">fa fa-eye-slash</span></a></li><li><a data-class="fa fa-exclamation-triangle " data-index="106"><span class="fa fa-exclamation-triangle"></span> <span class="name-class">fa fa-exclamation-triangle</span></a></li><li><a data-class="fa fa-plane " data-index="107"><span class="fa fa-plane"></span> <span class="name-class">fa fa-plane</span></a></li><li><a data-class="fa fa-calendar " data-index="108"><span class="fa fa-calendar"></span> <span class="name-class">fa fa-calendar</span></a></li><li><a data-class="fa fa-random " data-index="109"><span class="fa fa-random"></span> <span class="name-class">fa fa-random</span></a></li><li><a data-class="fa fa-comment " data-index="110"><span class="fa fa-comment"></span> <span class="name-class">fa fa-comment</span></a></li><li><a data-class="fa fa-magnet " data-index="111"><span class="fa fa-magnet"></span> <span class="name-class">fa fa-magnet</span></a></li><li><a data-class="fa fa-chevron-up " data-index="112"><span class="fa fa-chevron-up"></span> <span class="name-class">fa fa-chevron-up</span></a></li><li><a data-class="fa fa-chevron-down " data-index="113"><span class="fa fa-chevron-down"></span> <span class="name-class">fa fa-chevron-down</span></a></li><li><a data-class="fa fa-retweet " data-index="114"><span class="fa fa-retweet"></span> <span class="name-class">fa fa-retweet</span></a></li><li><a data-class="fa fa-shopping-cart " data-index="115"><span class="fa fa-shopping-cart"></span> <span class="name-class">fa fa-shopping-cart</span></a></li><li><a data-class="fa fa-folder " data-index="116"><span class="fa fa-folder"></span> <span class="name-class">fa fa-folder</span></a></li><li><a data-class="fa fa-folder-open " data-index="117"><span class="fa fa-folder-open"></span> <span class="name-class">fa fa-folder-open</span></a></li><li><a data-class="fa fa-arrows-v " data-index="118"><span class="fa fa-arrows-v"></span> <span class="name-class">fa fa-arrows-v</span></a></li><li><a data-class="fa fa-arrows-h " data-index="119"><span class="fa fa-arrows-h"></span> <span class="name-class">fa fa-arrows-h</span></a></li><li><a data-class="fa fa-bar-chart " data-index="120"><span class="fa fa-bar-chart"></span> <span class="name-class">fa fa-bar-chart</span></a></li><li><a data-class="fa fa-twitter-square " data-index="121"><span class="fa fa-twitter-square"></span> <span class="name-class">fa fa-twitter-square</span></a></li><li><a data-class="fa fa-facebook-square " data-index="122"><span class="fa fa-facebook-square"></span> <span class="name-class">fa fa-facebook-square</span></a></li><li><a data-class="fa fa-camera-retro " data-index="123"><span class="fa fa-camera-retro"></span> <span class="name-class">fa fa-camera-retro</span></a></li><li><a data-class="fa fa-key " data-index="124"><span class="fa fa-key"></span> <span class="name-class">fa fa-key</span></a></li><li><a data-class="fa fa-cogs " data-index="125"><span class="fa fa-cogs"></span> <span class="name-class">fa fa-cogs</span></a></li><li><a data-class="fa fa-comments " data-index="126"><span class="fa fa-comments"></span> <span class="name-class">fa fa-comments</span></a></li><li><a data-class="fa fa-thumbs-o-up " data-index="127"><span class="fa fa-thumbs-o-up"></span> <span class="name-class">fa fa-thumbs-o-up</span></a></li><li><a data-class="fa fa-thumbs-o-down " data-index="128"><span class="fa fa-thumbs-o-down"></span> <span class="name-class">fa fa-thumbs-o-down</span></a></li><li><a data-class="fa fa-star-half " data-index="129"><span class="fa fa-star-half"></span> <span class="name-class">fa fa-star-half</span></a></li><li><a data-class="fa fa-heart-o " data-index="130"><span class="fa fa-heart-o"></span> <span class="name-class">fa fa-heart-o</span></a></li><li><a data-class="fa fa-sign-out " data-index="131"><span class="fa fa-sign-out"></span> <span class="name-class">fa fa-sign-out</span></a></li><li><a data-class="fa fa-linkedin-square " data-index="132"><span class="fa fa-linkedin-square"></span> <span class="name-class">fa fa-linkedin-square</span></a></li><li><a data-class="fa fa-thumb-tack " data-index="133"><span class="fa fa-thumb-tack"></span> <span class="name-class">fa fa-thumb-tack</span></a></li><li><a data-class="fa fa-external-link " data-index="134"><span class="fa fa-external-link"></span> <span class="name-class">fa fa-external-link</span></a></li><li><a data-class="fa fa-sign-in " data-index="135"><span class="fa fa-sign-in"></span> <span class="name-class">fa fa-sign-in</span></a></li><li><a data-class="fa fa-trophy " data-index="136"><span class="fa fa-trophy"></span> <span class="name-class">fa fa-trophy</span></a></li><li><a data-class="fa fa-github-square " data-index="137"><span class="fa fa-github-square"></span> <span class="name-class">fa fa-github-square</span></a></li><li><a data-class="fa fa-upload " data-index="138"><span class="fa fa-upload"></span> <span class="name-class">fa fa-upload</span></a></li><li><a data-class="fa fa-lemon-o " data-index="139"><span class="fa fa-lemon-o"></span> <span class="name-class">fa fa-lemon-o</span></a></li><li><a data-class="fa fa-phone " data-index="140"><span class="fa fa-phone"></span> <span class="name-class">fa fa-phone</span></a></li><li><a data-class="fa fa-square-o " data-index="141"><span class="fa fa-square-o"></span> <span class="name-class">fa fa-square-o</span></a></li><li><a data-class="fa fa-bookmark-o " data-index="142"><span class="fa fa-bookmark-o"></span> <span class="name-class">fa fa-bookmark-o</span></a></li><li><a data-class="fa fa-phone-square " data-index="143"><span class="fa fa-phone-square"></span> <span class="name-class">fa fa-phone-square</span></a></li><li><a data-class="fa fa-twitter " data-index="144"><span class="fa fa-twitter"></span> <span class="name-class">fa fa-twitter</span></a></li><li><a data-class="fa fa-facebook " data-index="145"><span class="fa fa-facebook"></span> <span class="name-class">fa fa-facebook</span></a></li><li><a data-class="fa fa-github " data-index="146"><span class="fa fa-github"></span> <span class="name-class">fa fa-github</span></a></li><li><a data-class="fa fa-unlock " data-index="147"><span class="fa fa-unlock"></span> <span class="name-class">fa fa-unlock</span></a></li><li><a data-class="fa fa-credit-card " data-index="148"><span class="fa fa-credit-card"></span> <span class="name-class">fa fa-credit-card</span></a></li><li><a data-class="fa fa-rss " data-index="149"><span class="fa fa-rss"></span> <span class="name-class">fa fa-rss</span></a></li><li><a data-class="fa fa-hdd-o " data-index="150"><span class="fa fa-hdd-o"></span> <span class="name-class">fa fa-hdd-o</span></a></li><li><a data-class="fa fa-bullhorn " data-index="151"><span class="fa fa-bullhorn"></span> <span class="name-class">fa fa-bullhorn</span></a></li><li><a data-class="fa fa-bell " data-index="152"><span class="fa fa-bell"></span> <span class="name-class">fa fa-bell</span></a></li><li><a data-class="fa fa-certificate " data-index="153"><span class="fa fa-certificate"></span> <span class="name-class">fa fa-certificate</span></a></li><li><a data-class="fa fa-hand-o-right " data-index="154"><span class="fa fa-hand-o-right"></span> <span class="name-class">fa fa-hand-o-right</span></a></li><li><a data-class="fa fa-hand-o-left " data-index="155"><span class="fa fa-hand-o-left"></span> <span class="name-class">fa fa-hand-o-left</span></a></li><li><a data-class="fa fa-hand-o-up " data-index="156"><span class="fa fa-hand-o-up"></span> <span class="name-class">fa fa-hand-o-up</span></a></li><li><a data-class="fa fa-hand-o-down " data-index="157"><span class="fa fa-hand-o-down"></span> <span class="name-class">fa fa-hand-o-down</span></a></li><li><a data-class="fa fa-arrow-circle-left " data-index="158"><span class="fa fa-arrow-circle-left"></span> <span class="name-class">fa fa-arrow-circle-left</span></a></li><li><a data-class="fa fa-arrow-circle-right " data-index="159"><span class="fa fa-arrow-circle-right"></span> <span class="name-class">fa fa-arrow-circle-right</span></a></li><li><a data-class="fa fa-arrow-circle-up " data-index="160"><span class="fa fa-arrow-circle-up"></span> <span class="name-class">fa fa-arrow-circle-up</span></a></li><li><a data-class="fa fa-arrow-circle-down " data-index="161"><span class="fa fa-arrow-circle-down"></span> <span class="name-class">fa fa-arrow-circle-down</span></a></li><li><a data-class="fa fa-globe " data-index="162"><span class="fa fa-globe"></span> <span class="name-class">fa fa-globe</span></a></li><li><a data-class="fa fa-wrench " data-index="163"><span class="fa fa-wrench"></span> <span class="name-class">fa fa-wrench</span></a></li><li><a data-class="fa fa-tasks " data-index="164"><span class="fa fa-tasks"></span> <span class="name-class">fa fa-tasks</span></a></li><li><a data-class="fa fa-filter " data-index="165"><span class="fa fa-filter"></span> <span class="name-class">fa fa-filter</span></a></li><li><a data-class="fa fa-briefcase " data-index="166"><span class="fa fa-briefcase"></span> <span class="name-class">fa fa-briefcase</span></a></li><li><a data-class="fa fa-arrows-alt " data-index="167"><span class="fa fa-arrows-alt"></span> <span class="name-class">fa fa-arrows-alt</span></a></li><li><a data-class="fa fa-users " data-index="168"><span class="fa fa-users"></span> <span class="name-class">fa fa-users</span></a></li><li><a data-class="fa fa-link " data-index="169"><span class="fa fa-link"></span> <span class="name-class">fa fa-link</span></a></li><li><a data-class="fa fa-cloud " data-index="170"><span class="fa fa-cloud"></span> <span class="name-class">fa fa-cloud</span></a></li><li><a data-class="fa fa-flask " data-index="171"><span class="fa fa-flask"></span> <span class="name-class">fa fa-flask</span></a></li><li><a data-class="fa fa-scissors " data-index="172"><span class="fa fa-scissors"></span> <span class="name-class">fa fa-scissors</span></a></li><li><a data-class="fa fa-files-o " data-index="173"><span class="fa fa-files-o"></span> <span class="name-class">fa fa-files-o</span></a></li><li><a data-class="fa fa-paperclip " data-index="174"><span class="fa fa-paperclip"></span> <span class="name-class">fa fa-paperclip</span></a></li><li><a data-class="fa fa-floppy-o " data-index="175"><span class="fa fa-floppy-o"></span> <span class="name-class">fa fa-floppy-o</span></a></li><li><a data-class="fa fa-square " data-index="176"><span class="fa fa-square"></span> <span class="name-class">fa fa-square</span></a></li><li><a data-class="fa fa-bars " data-index="177"><span class="fa fa-bars"></span> <span class="name-class">fa fa-bars</span></a></li><li><a data-class="fa fa-list-ul " data-index="178"><span class="fa fa-list-ul"></span> <span class="name-class">fa fa-list-ul</span></a></li><li><a data-class="fa fa-list-ol " data-index="179"><span class="fa fa-list-ol"></span> <span class="name-class">fa fa-list-ol</span></a></li><li><a data-class="fa fa-strikethrough " data-index="180"><span class="fa fa-strikethrough"></span> <span class="name-class">fa fa-strikethrough</span></a></li><li><a data-class="fa fa-underline " data-index="181"><span class="fa fa-underline"></span> <span class="name-class">fa fa-underline</span></a></li><li><a data-class="fa fa-table " data-index="182"><span class="fa fa-table"></span> <span class="name-class">fa fa-table</span></a></li><li><a data-class="fa fa-magic " data-index="183"><span class="fa fa-magic"></span> <span class="name-class">fa fa-magic</span></a></li><li><a data-class="fa fa-truck " data-index="184"><span class="fa fa-truck"></span> <span class="name-class">fa fa-truck</span></a></li><li><a data-class="fa fa-pinterest " data-index="185"><span class="fa fa-pinterest"></span> <span class="name-class">fa fa-pinterest</span></a></li><li><a data-class="fa fa-pinterest-square " data-index="186"><span class="fa fa-pinterest-square"></span> <span class="name-class">fa fa-pinterest-square</span></a></li><li><a data-class="fa fa-google-plus-square " data-index="187"><span class="fa fa-google-plus-square"></span> <span class="name-class">fa fa-google-plus-square</span></a></li><li><a data-class="fa fa-google-plus " data-index="188"><span class="fa fa-google-plus"></span> <span class="name-class">fa fa-google-plus</span></a></li><li><a data-class="fa fa-money " data-index="189"><span class="fa fa-money"></span> <span class="name-class">fa fa-money</span></a></li><li><a data-class="fa fa-caret-down " data-index="190"><span class="fa fa-caret-down"></span> <span class="name-class">fa fa-caret-down</span></a></li><li><a data-class="fa fa-caret-up " data-index="191"><span class="fa fa-caret-up"></span> <span class="name-class">fa fa-caret-up</span></a></li><li><a data-class="fa fa-caret-left " data-index="192"><span class="fa fa-caret-left"></span> <span class="name-class">fa fa-caret-left</span></a></li><li><a data-class="fa fa-caret-right " data-index="193"><span class="fa fa-caret-right"></span> <span class="name-class">fa fa-caret-right</span></a></li><li><a data-class="fa fa-columns " data-index="194"><span class="fa fa-columns"></span> <span class="name-class">fa fa-columns</span></a></li><li><a data-class="fa fa-sort " data-index="195"><span class="fa fa-sort"></span> <span class="name-class">fa fa-sort</span></a></li><li><a data-class="fa fa-sort-desc " data-index="196"><span class="fa fa-sort-desc"></span> <span class="name-class">fa fa-sort-desc</span></a></li><li><a data-class="fa fa-sort-asc " data-index="197"><span class="fa fa-sort-asc"></span> <span class="name-class">fa fa-sort-asc</span></a></li><li><a data-class="fa fa-envelope " data-index="198"><span class="fa fa-envelope"></span> <span class="name-class">fa fa-envelope</span></a></li><li><a data-class="fa fa-linkedin " data-index="199"><span class="fa fa-linkedin"></span> <span class="name-class">fa fa-linkedin</span></a></li><li><a data-class="fa fa-undo " data-index="200"><span class="fa fa-undo"></span> <span class="name-class">fa fa-undo</span></a></li><li><a data-class="fa fa-gavel " data-index="201"><span class="fa fa-gavel"></span> <span class="name-class">fa fa-gavel</span></a></li><li><a data-class="fa fa-tachometer " data-index="202"><span class="fa fa-tachometer"></span> <span class="name-class">fa fa-tachometer</span></a></li><li><a data-class="fa fa-comment-o " data-index="203"><span class="fa fa-comment-o"></span> <span class="name-class">fa fa-comment-o</span></a></li><li><a data-class="fa fa-comments-o " data-index="204"><span class="fa fa-comments-o"></span> <span class="name-class">fa fa-comments-o</span></a></li><li><a data-class="fa fa-bolt " data-index="205"><span class="fa fa-bolt"></span> <span class="name-class">fa fa-bolt</span></a></li><li><a data-class="fa fa-sitemap " data-index="206"><span class="fa fa-sitemap"></span> <span class="name-class">fa fa-sitemap</span></a></li><li><a data-class="fa fa-umbrella " data-index="207"><span class="fa fa-umbrella"></span> <span class="name-class">fa fa-umbrella</span></a></li><li><a data-class="fa fa-clipboard " data-index="208"><span class="fa fa-clipboard"></span> <span class="name-class">fa fa-clipboard</span></a></li><li><a data-class="fa fa-lightbulb-o " data-index="209"><span class="fa fa-lightbulb-o"></span> <span class="name-class">fa fa-lightbulb-o</span></a></li><li><a data-class="fa fa-exchange " data-index="210"><span class="fa fa-exchange"></span> <span class="name-class">fa fa-exchange</span></a></li><li><a data-class="fa fa-cloud-download " data-index="211"><span class="fa fa-cloud-download"></span> <span class="name-class">fa fa-cloud-download</span></a></li><li><a data-class="fa fa-cloud-upload " data-index="212"><span class="fa fa-cloud-upload"></span> <span class="name-class">fa fa-cloud-upload</span></a></li><li><a data-class="fa fa-user-md " data-index="213"><span class="fa fa-user-md"></span> <span class="name-class">fa fa-user-md</span></a></li><li><a data-class="fa fa-stethoscope " data-index="214"><span class="fa fa-stethoscope"></span> <span class="name-class">fa fa-stethoscope</span></a></li><li><a data-class="fa fa-suitcase " data-index="215"><span class="fa fa-suitcase"></span> <span class="name-class">fa fa-suitcase</span></a></li><li><a data-class="fa fa-bell-o " data-index="216"><span class="fa fa-bell-o"></span> <span class="name-class">fa fa-bell-o</span></a></li><li><a data-class="fa fa-coffee " data-index="217"><span class="fa fa-coffee"></span> <span class="name-class">fa fa-coffee</span></a></li><li><a data-class="fa fa-cutlery " data-index="218"><span class="fa fa-cutlery"></span> <span class="name-class">fa fa-cutlery</span></a></li><li><a data-class="fa fa-file-text-o " data-index="219"><span class="fa fa-file-text-o"></span> <span class="name-class">fa fa-file-text-o</span></a></li><li><a data-class="fa fa-building-o " data-index="220"><span class="fa fa-building-o"></span> <span class="name-class">fa fa-building-o</span></a></li><li><a data-class="fa fa-hospital-o " data-index="221"><span class="fa fa-hospital-o"></span> <span class="name-class">fa fa-hospital-o</span></a></li><li><a data-class="fa fa-ambulance " data-index="222"><span class="fa fa-ambulance"></span> <span class="name-class">fa fa-ambulance</span></a></li><li><a data-class="fa fa-medkit " data-index="223"><span class="fa fa-medkit"></span> <span class="name-class">fa fa-medkit</span></a></li><li><a data-class="fa fa-fighter-jet " data-index="224"><span class="fa fa-fighter-jet"></span> <span class="name-class">fa fa-fighter-jet</span></a></li><li><a data-class="fa fa-beer " data-index="225"><span class="fa fa-beer"></span> <span class="name-class">fa fa-beer</span></a></li><li><a data-class="fa fa-h-square " data-index="226"><span class="fa fa-h-square"></span> <span class="name-class">fa fa-h-square</span></a></li><li><a data-class="fa fa-plus-square " data-index="227"><span class="fa fa-plus-square"></span> <span class="name-class">fa fa-plus-square</span></a></li><li><a data-class="fa fa-angle-double-left " data-index="228"><span class="fa fa-angle-double-left"></span> <span class="name-class">fa fa-angle-double-left</span></a></li><li><a data-class="fa fa-angle-double-right " data-index="229"><span class="fa fa-angle-double-right"></span> <span class="name-class">fa fa-angle-double-right</span></a></li><li><a data-class="fa fa-angle-double-up " data-index="230"><span class="fa fa-angle-double-up"></span> <span class="name-class">fa fa-angle-double-up</span></a></li><li><a data-class="fa fa-angle-double-down " data-index="231"><span class="fa fa-angle-double-down"></span> <span class="name-class">fa fa-angle-double-down</span></a></li><li><a data-class="fa fa-angle-left " data-index="232"><span class="fa fa-angle-left"></span> <span class="name-class">fa fa-angle-left</span></a></li><li><a data-class="fa fa-angle-right " data-index="233"><span class="fa fa-angle-right"></span> <span class="name-class">fa fa-angle-right</span></a></li><li><a data-class="fa fa-angle-up " data-index="234"><span class="fa fa-angle-up"></span> <span class="name-class">fa fa-angle-up</span></a></li><li><a data-class="fa fa-angle-down " data-index="235"><span class="fa fa-angle-down"></span> <span class="name-class">fa fa-angle-down</span></a></li><li><a data-class="fa fa-desktop " data-index="236"><span class="fa fa-desktop"></span> <span class="name-class">fa fa-desktop</span></a></li><li><a data-class="fa fa-laptop " data-index="237"><span class="fa fa-laptop"></span> <span class="name-class">fa fa-laptop</span></a></li><li><a data-class="fa fa-tablet " data-index="238"><span class="fa fa-tablet"></span> <span class="name-class">fa fa-tablet</span></a></li><li><a data-class="fa fa-mobile " data-index="239"><span class="fa fa-mobile"></span> <span class="name-class">fa fa-mobile</span></a></li><li><a data-class="fa fa-circle-o " data-index="240"><span class="fa fa-circle-o"></span> <span class="name-class">fa fa-circle-o</span></a></li><li><a data-class="fa fa-quote-left " data-index="241"><span class="fa fa-quote-left"></span> <span class="name-class">fa fa-quote-left</span></a></li><li><a data-class="fa fa-quote-right " data-index="242"><span class="fa fa-quote-right"></span> <span class="name-class">fa fa-quote-right</span></a></li><li><a data-class="fa fa-spinner " data-index="243"><span class="fa fa-spinner"></span> <span class="name-class">fa fa-spinner</span></a></li><li><a data-class="fa fa-circle " data-index="244"><span class="fa fa-circle"></span> <span class="name-class">fa fa-circle</span></a></li><li><a data-class="fa fa-reply " data-index="245"><span class="fa fa-reply"></span> <span class="name-class">fa fa-reply</span></a></li><li><a data-class="fa fa-github-alt " data-index="246"><span class="fa fa-github-alt"></span> <span class="name-class">fa fa-github-alt</span></a></li><li><a data-class="fa fa-folder-o " data-index="247"><span class="fa fa-folder-o"></span> <span class="name-class">fa fa-folder-o</span></a></li><li><a data-class="fa fa-folder-open-o " data-index="248"><span class="fa fa-folder-open-o"></span> <span class="name-class">fa fa-folder-open-o</span></a></li><li><a data-class="fa fa-smile-o " data-index="249"><span class="fa fa-smile-o"></span> <span class="name-class">fa fa-smile-o</span></a></li><li><a data-class="fa fa-frown-o " data-index="250"><span class="fa fa-frown-o"></span> <span class="name-class">fa fa-frown-o</span></a></li><li><a data-class="fa fa-meh-o " data-index="251"><span class="fa fa-meh-o"></span> <span class="name-class">fa fa-meh-o</span></a></li><li><a data-class="fa fa-gamepad " data-index="252"><span class="fa fa-gamepad"></span> <span class="name-class">fa fa-gamepad</span></a></li><li><a data-class="fa fa-keyboard-o " data-index="253"><span class="fa fa-keyboard-o"></span> <span class="name-class">fa fa-keyboard-o</span></a></li><li><a data-class="fa fa-flag-o " data-index="254"><span class="fa fa-flag-o"></span> <span class="name-class">fa fa-flag-o</span></a></li><li><a data-class="fa fa-flag-checkered " data-index="255"><span class="fa fa-flag-checkered"></span> <span class="name-class">fa fa-flag-checkered</span></a></li><li><a data-class="fa fa-terminal " data-index="256"><span class="fa fa-terminal"></span> <span class="name-class">fa fa-terminal</span></a></li><li><a data-class="fa fa-code " data-index="257"><span class="fa fa-code"></span> <span class="name-class">fa fa-code</span></a></li><li><a data-class="fa fa-reply-all " data-index="258"><span class="fa fa-reply-all"></span> <span class="name-class">fa fa-reply-all</span></a></li><li><a data-class="fa fa-star-half-o " data-index="259"><span class="fa fa-star-half-o"></span> <span class="name-class">fa fa-star-half-o</span></a></li><li><a data-class="fa fa-location-arrow " data-index="260"><span class="fa fa-location-arrow"></span> <span class="name-class">fa fa-location-arrow</span></a></li><li><a data-class="fa fa-crop " data-index="261"><span class="fa fa-crop"></span> <span class="name-class">fa fa-crop</span></a></li><li><a data-class="fa fa-code-fork " data-index="262"><span class="fa fa-code-fork"></span> <span class="name-class">fa fa-code-fork</span></a></li><li><a data-class="fa fa-chain-broken " data-index="263"><span class="fa fa-chain-broken"></span> <span class="name-class">fa fa-chain-broken</span></a></li><li><a data-class="fa fa-question " data-index="264"><span class="fa fa-question"></span> <span class="name-class">fa fa-question</span></a></li><li><a data-class="fa fa-info " data-index="265"><span class="fa fa-info"></span> <span class="name-class">fa fa-info</span></a></li><li><a data-class="fa fa-exclamation " data-index="266"><span class="fa fa-exclamation"></span> <span class="name-class">fa fa-exclamation</span></a></li><li><a data-class="fa fa-superscript " data-index="267"><span class="fa fa-superscript"></span> <span class="name-class">fa fa-superscript</span></a></li><li><a data-class="fa fa-subscript " data-index="268"><span class="fa fa-subscript"></span> <span class="name-class">fa fa-subscript</span></a></li><li><a data-class="fa fa-eraser " data-index="269"><span class="fa fa-eraser"></span> <span class="name-class">fa fa-eraser</span></a></li><li><a data-class="fa fa-puzzle-piece " data-index="270"><span class="fa fa-puzzle-piece"></span> <span class="name-class">fa fa-puzzle-piece</span></a></li><li><a data-class="fa fa-microphone " data-index="271"><span class="fa fa-microphone"></span> <span class="name-class">fa fa-microphone</span></a></li><li><a data-class="fa fa-microphone-slash " data-index="272"><span class="fa fa-microphone-slash"></span> <span class="name-class">fa fa-microphone-slash</span></a></li><li><a data-class="fa fa-shield " data-index="273"><span class="fa fa-shield"></span> <span class="name-class">fa fa-shield</span></a></li><li><a data-class="fa fa-calendar-o " data-index="274"><span class="fa fa-calendar-o"></span> <span class="name-class">fa fa-calendar-o</span></a></li><li><a data-class="fa fa-fire-extinguisher " data-index="275"><span class="fa fa-fire-extinguisher"></span> <span class="name-class">fa fa-fire-extinguisher</span></a></li><li><a data-class="fa fa-rocket " data-index="276"><span class="fa fa-rocket"></span> <span class="name-class">fa fa-rocket</span></a></li><li><a data-class="fa fa-maxcdn " data-index="277"><span class="fa fa-maxcdn"></span> <span class="name-class">fa fa-maxcdn</span></a></li><li><a data-class="fa fa-chevron-circle-left " data-index="278"><span class="fa fa-chevron-circle-left"></span> <span class="name-class">fa fa-chevron-circle-left</span></a></li><li><a data-class="fa fa-chevron-circle-right " data-index="279"><span class="fa fa-chevron-circle-right"></span> <span class="name-class">fa fa-chevron-circle-right</span></a></li><li><a data-class="fa fa-chevron-circle-up " data-index="280"><span class="fa fa-chevron-circle-up"></span> <span class="name-class">fa fa-chevron-circle-up</span></a></li><li><a data-class="fa fa-chevron-circle-down " data-index="281"><span class="fa fa-chevron-circle-down"></span> <span class="name-class">fa fa-chevron-circle-down</span></a></li><li><a data-class="fa fa-html5 " data-index="282"><span class="fa fa-html5"></span> <span class="name-class">fa fa-html5</span></a></li><li><a data-class="fa fa-css3 " data-index="283"><span class="fa fa-css3"></span> <span class="name-class">fa fa-css3</span></a></li><li><a data-class="fa fa-anchor " data-index="284"><span class="fa fa-anchor"></span> <span class="name-class">fa fa-anchor</span></a></li><li><a data-class="fa fa-unlock-alt " data-index="285"><span class="fa fa-unlock-alt"></span> <span class="name-class">fa fa-unlock-alt</span></a></li><li><a data-class="fa fa-bullseye " data-index="286"><span class="fa fa-bullseye"></span> <span class="name-class">fa fa-bullseye</span></a></li><li><a data-class="fa fa-ellipsis-h " data-index="287"><span class="fa fa-ellipsis-h"></span> <span class="name-class">fa fa-ellipsis-h</span></a></li><li><a data-class="fa fa-ellipsis-v " data-index="288"><span class="fa fa-ellipsis-v"></span> <span class="name-class">fa fa-ellipsis-v</span></a></li><li><a data-class="fa fa-rss-square " data-index="289"><span class="fa fa-rss-square"></span> <span class="name-class">fa fa-rss-square</span></a></li><li><a data-class="fa fa-play-circle " data-index="290"><span class="fa fa-play-circle"></span> <span class="name-class">fa fa-play-circle</span></a></li><li><a data-class="fa fa-ticket " data-index="291"><span class="fa fa-ticket"></span> <span class="name-class">fa fa-ticket</span></a></li><li><a data-class="fa fa-minus-square " data-index="292"><span class="fa fa-minus-square"></span> <span class="name-class">fa fa-minus-square</span></a></li><li><a data-class="fa fa-minus-square-o " data-index="293"><span class="fa fa-minus-square-o"></span> <span class="name-class">fa fa-minus-square-o</span></a></li><li><a data-class="fa fa-level-up " data-index="294"><span class="fa fa-level-up"></span> <span class="name-class">fa fa-level-up</span></a></li><li><a data-class="fa fa-level-down " data-index="295"><span class="fa fa-level-down"></span> <span class="name-class">fa fa-level-down</span></a></li><li><a data-class="fa fa-check-square " data-index="296"><span class="fa fa-check-square"></span> <span class="name-class">fa fa-check-square</span></a></li><li><a data-class="fa fa-pencil-square " data-index="297"><span class="fa fa-pencil-square"></span> <span class="name-class">fa fa-pencil-square</span></a></li><li><a data-class="fa fa-external-link-square " data-index="298"><span class="fa fa-external-link-square"></span> <span class="name-class">fa fa-external-link-square</span></a></li><li><a data-class="fa fa-share-square " data-index="299"><span class="fa fa-share-square"></span> <span class="name-class">fa fa-share-square</span></a></li><li><a data-class="fa fa-compass " data-index="300"><span class="fa fa-compass"></span> <span class="name-class">fa fa-compass</span></a></li><li><a data-class="fa fa-caret-square-o-down " data-index="301"><span class="fa fa-caret-square-o-down"></span> <span class="name-class">fa fa-caret-square-o-down</span></a></li><li><a data-class="fa fa-caret-square-o-up " data-index="302"><span class="fa fa-caret-square-o-up"></span> <span class="name-class">fa fa-caret-square-o-up</span></a></li><li><a data-class="fa fa-caret-square-o-right " data-index="303"><span class="fa fa-caret-square-o-right"></span> <span class="name-class">fa fa-caret-square-o-right</span></a></li><li><a data-class="fa fa-eur " data-index="304"><span class="fa fa-eur"></span> <span class="name-class">fa fa-eur</span></a></li><li><a data-class="fa fa-gbp " data-index="305"><span class="fa fa-gbp"></span> <span class="name-class">fa fa-gbp</span></a></li><li><a data-class="fa fa-usd " data-index="306"><span class="fa fa-usd"></span> <span class="name-class">fa fa-usd</span></a></li><li><a data-class="fa fa-inr " data-index="307"><span class="fa fa-inr"></span> <span class="name-class">fa fa-inr</span></a></li><li><a data-class="fa fa-jpy " data-index="308"><span class="fa fa-jpy"></span> <span class="name-class">fa fa-jpy</span></a></li><li><a data-class="fa fa-rub " data-index="309"><span class="fa fa-rub"></span> <span class="name-class">fa fa-rub</span></a></li><li><a data-class="fa fa-krw " data-index="310"><span class="fa fa-krw"></span> <span class="name-class">fa fa-krw</span></a></li><li><a data-class="fa fa-btc " data-index="311"><span class="fa fa-btc"></span> <span class="name-class">fa fa-btc</span></a></li><li><a data-class="fa fa-file " data-index="312"><span class="fa fa-file"></span> <span class="name-class">fa fa-file</span></a></li><li><a data-class="fa fa-file-text " data-index="313"><span class="fa fa-file-text"></span> <span class="name-class">fa fa-file-text</span></a></li><li><a data-class="fa fa-sort-alpha-asc " data-index="314"><span class="fa fa-sort-alpha-asc"></span> <span class="name-class">fa fa-sort-alpha-asc</span></a></li><li><a data-class="fa fa-sort-alpha-desc " data-index="315"><span class="fa fa-sort-alpha-desc"></span> <span class="name-class">fa fa-sort-alpha-desc</span></a></li><li><a data-class="fa fa-sort-amount-asc " data-index="316"><span class="fa fa-sort-amount-asc"></span> <span class="name-class">fa fa-sort-amount-asc</span></a></li><li><a data-class="fa fa-sort-amount-desc " data-index="317"><span class="fa fa-sort-amount-desc"></span> <span class="name-class">fa fa-sort-amount-desc</span></a></li><li><a data-class="fa fa-sort-numeric-asc " data-index="318"><span class="fa fa-sort-numeric-asc"></span> <span class="name-class">fa fa-sort-numeric-asc</span></a></li><li><a data-class="fa fa-sort-numeric-desc " data-index="319"><span class="fa fa-sort-numeric-desc"></span> <span class="name-class">fa fa-sort-numeric-desc</span></a></li><li><a data-class="fa fa-thumbs-up " data-index="320"><span class="fa fa-thumbs-up"></span> <span class="name-class">fa fa-thumbs-up</span></a></li><li><a data-class="fa fa-thumbs-down " data-index="321"><span class="fa fa-thumbs-down"></span> <span class="name-class">fa fa-thumbs-down</span></a></li><li><a data-class="fa fa-youtube-square " data-index="322"><span class="fa fa-youtube-square"></span> <span class="name-class">fa fa-youtube-square</span></a></li><li><a data-class="fa fa-youtube " data-index="323"><span class="fa fa-youtube"></span> <span class="name-class">fa fa-youtube</span></a></li><li><a data-class="fa fa-xing " data-index="324"><span class="fa fa-xing"></span> <span class="name-class">fa fa-xing</span></a></li><li><a data-class="fa fa-xing-square " data-index="325"><span class="fa fa-xing-square"></span> <span class="name-class">fa fa-xing-square</span></a></li><li><a data-class="fa fa-youtube-play " data-index="326"><span class="fa fa-youtube-play"></span> <span class="name-class">fa fa-youtube-play</span></a></li><li><a data-class="fa fa-dropbox " data-index="327"><span class="fa fa-dropbox"></span> <span class="name-class">fa fa-dropbox</span></a></li><li><a data-class="fa fa-stack-overflow " data-index="328"><span class="fa fa-stack-overflow"></span> <span class="name-class">fa fa-stack-overflow</span></a></li><li><a data-class="fa fa-instagram " data-index="329"><span class="fa fa-instagram"></span> <span class="name-class">fa fa-instagram</span></a></li><li><a data-class="fa fa-flickr " data-index="330"><span class="fa fa-flickr"></span> <span class="name-class">fa fa-flickr</span></a></li><li><a data-class="fa fa-adn " data-index="331"><span class="fa fa-adn"></span> <span class="name-class">fa fa-adn</span></a></li><li><a data-class="fa fa-bitbucket " data-index="332"><span class="fa fa-bitbucket"></span> <span class="name-class">fa fa-bitbucket</span></a></li><li><a data-class="fa fa-bitbucket-square " data-index="333"><span class="fa fa-bitbucket-square"></span> <span class="name-class">fa fa-bitbucket-square</span></a></li><li><a data-class="fa fa-tumblr " data-index="334"><span class="fa fa-tumblr"></span> <span class="name-class">fa fa-tumblr</span></a></li><li><a data-class="fa fa-tumblr-square " data-index="335"><span class="fa fa-tumblr-square"></span> <span class="name-class">fa fa-tumblr-square</span></a></li><li><a data-class="fa fa-long-arrow-down " data-index="336"><span class="fa fa-long-arrow-down"></span> <span class="name-class">fa fa-long-arrow-down</span></a></li><li><a data-class="fa fa-long-arrow-up " data-index="337"><span class="fa fa-long-arrow-up"></span> <span class="name-class">fa fa-long-arrow-up</span></a></li><li><a data-class="fa fa-long-arrow-left " data-index="338"><span class="fa fa-long-arrow-left"></span> <span class="name-class">fa fa-long-arrow-left</span></a></li><li><a data-class="fa fa-long-arrow-right " data-index="339"><span class="fa fa-long-arrow-right"></span> <span class="name-class">fa fa-long-arrow-right</span></a></li><li><a data-class="fa fa-apple " data-index="340"><span class="fa fa-apple"></span> <span class="name-class">fa fa-apple</span></a></li><li><a data-class="fa fa-windows " data-index="341"><span class="fa fa-windows"></span> <span class="name-class">fa fa-windows</span></a></li><li><a data-class="fa fa-android " data-index="342"><span class="fa fa-android"></span> <span class="name-class">fa fa-android</span></a></li><li><a data-class="fa fa-linux " data-index="343"><span class="fa fa-linux"></span> <span class="name-class">fa fa-linux</span></a></li><li><a data-class="fa fa-dribbble " data-index="344"><span class="fa fa-dribbble"></span> <span class="name-class">fa fa-dribbble</span></a></li><li><a data-class="fa fa-skype " data-index="345"><span class="fa fa-skype"></span> <span class="name-class">fa fa-skype</span></a></li><li><a data-class="fa fa-foursquare " data-index="346"><span class="fa fa-foursquare"></span> <span class="name-class">fa fa-foursquare</span></a></li><li><a data-class="fa fa-trello " data-index="347"><span class="fa fa-trello"></span> <span class="name-class">fa fa-trello</span></a></li><li><a data-class="fa fa-female " data-index="348"><span class="fa fa-female"></span> <span class="name-class">fa fa-female</span></a></li><li><a data-class="fa fa-male " data-index="349"><span class="fa fa-male"></span> <span class="name-class">fa fa-male</span></a></li><li><a data-class="fa fa-gratipay " data-index="350"><span class="fa fa-gratipay"></span> <span class="name-class">fa fa-gratipay</span></a></li><li><a data-class="fa fa-sun-o " data-index="351"><span class="fa fa-sun-o"></span> <span class="name-class">fa fa-sun-o</span></a></li><li><a data-class="fa fa-moon-o " data-index="352"><span class="fa fa-moon-o"></span> <span class="name-class">fa fa-moon-o</span></a></li><li><a data-class="fa fa-archive " data-index="353"><span class="fa fa-archive"></span> <span class="name-class">fa fa-archive</span></a></li><li><a data-class="fa fa-bug " data-index="354"><span class="fa fa-bug"></span> <span class="name-class">fa fa-bug</span></a></li><li><a data-class="fa fa-vk " data-index="355"><span class="fa fa-vk"></span> <span class="name-class">fa fa-vk</span></a></li><li><a data-class="fa fa-weibo " data-index="356"><span class="fa fa-weibo"></span> <span class="name-class">fa fa-weibo</span></a></li><li><a data-class="fa fa-renren " data-index="357"><span class="fa fa-renren"></span> <span class="name-class">fa fa-renren</span></a></li><li><a data-class="fa fa-pagelines " data-index="358"><span class="fa fa-pagelines"></span> <span class="name-class">fa fa-pagelines</span></a></li><li><a data-class="fa fa-stack-exchange " data-index="359"><span class="fa fa-stack-exchange"></span> <span class="name-class">fa fa-stack-exchange</span></a></li><li><a data-class="fa fa-arrow-circle-o-right " data-index="360"><span class="fa fa-arrow-circle-o-right"></span> <span class="name-class">fa fa-arrow-circle-o-right</span></a></li><li><a data-class="fa fa-arrow-circle-o-left " data-index="361"><span class="fa fa-arrow-circle-o-left"></span> <span class="name-class">fa fa-arrow-circle-o-left</span></a></li><li><a data-class="fa fa-caret-square-o-left " data-index="362"><span class="fa fa-caret-square-o-left"></span> <span class="name-class">fa fa-caret-square-o-left</span></a></li><li><a data-class="fa fa-dot-circle-o " data-index="363"><span class="fa fa-dot-circle-o"></span> <span class="name-class">fa fa-dot-circle-o</span></a></li><li><a data-class="fa fa-wheelchair " data-index="364"><span class="fa fa-wheelchair"></span> <span class="name-class">fa fa-wheelchair</span></a></li><li><a data-class="fa fa-vimeo-square " data-index="365"><span class="fa fa-vimeo-square"></span> <span class="name-class">fa fa-vimeo-square</span></a></li><li><a data-class="fa fa-try " data-index="366"><span class="fa fa-try"></span> <span class="name-class">fa fa-try</span></a></li><li><a data-class="fa fa-plus-square-o " data-index="367"><span class="fa fa-plus-square-o"></span> <span class="name-class">fa fa-plus-square-o</span></a></li><li><a data-class="fa fa-space-shuttle " data-index="368"><span class="fa fa-space-shuttle"></span> <span class="name-class">fa fa-space-shuttle</span></a></li><li><a data-class="fa fa-slack " data-index="369"><span class="fa fa-slack"></span> <span class="name-class">fa fa-slack</span></a></li><li><a data-class="fa fa-envelope-square " data-index="370"><span class="fa fa-envelope-square"></span> <span class="name-class">fa fa-envelope-square</span></a></li><li><a data-class="fa fa-wordpress " data-index="371"><span class="fa fa-wordpress"></span> <span class="name-class">fa fa-wordpress</span></a></li><li><a data-class="fa fa-openid " data-index="372"><span class="fa fa-openid"></span> <span class="name-class">fa fa-openid</span></a></li><li><a data-class="fa fa-university " data-index="373"><span class="fa fa-university"></span> <span class="name-class">fa fa-university</span></a></li><li><a data-class="fa fa-graduation-cap " data-index="374"><span class="fa fa-graduation-cap"></span> <span class="name-class">fa fa-graduation-cap</span></a></li><li><a data-class="fa fa-yahoo " data-index="375"><span class="fa fa-yahoo"></span> <span class="name-class">fa fa-yahoo</span></a></li><li><a data-class="fa fa-google " data-index="376"><span class="fa fa-google"></span> <span class="name-class">fa fa-google</span></a></li><li><a data-class="fa fa-reddit " data-index="377"><span class="fa fa-reddit"></span> <span class="name-class">fa fa-reddit</span></a></li><li><a data-class="fa fa-reddit-square " data-index="378"><span class="fa fa-reddit-square"></span> <span class="name-class">fa fa-reddit-square</span></a></li><li><a data-class="fa fa-stumbleupon-circle " data-index="379"><span class="fa fa-stumbleupon-circle"></span> <span class="name-class">fa fa-stumbleupon-circle</span></a></li><li><a data-class="fa fa-stumbleupon " data-index="380"><span class="fa fa-stumbleupon"></span> <span class="name-class">fa fa-stumbleupon</span></a></li><li><a data-class="fa fa-delicious " data-index="381"><span class="fa fa-delicious"></span> <span class="name-class">fa fa-delicious</span></a></li><li><a data-class="fa fa-digg " data-index="382"><span class="fa fa-digg"></span> <span class="name-class">fa fa-digg</span></a></li><li><a data-class="fa fa-pied-piper " data-index="383"><span class="fa fa-pied-piper"></span> <span class="name-class">fa fa-pied-piper</span></a></li><li><a data-class="fa fa-pied-piper-alt " data-index="384"><span class="fa fa-pied-piper-alt"></span> <span class="name-class">fa fa-pied-piper-alt</span></a></li><li><a data-class="fa fa-drupal " data-index="385"><span class="fa fa-drupal"></span> <span class="name-class">fa fa-drupal</span></a></li><li><a data-class="fa fa-joomla " data-index="386"><span class="fa fa-joomla"></span> <span class="name-class">fa fa-joomla</span></a></li><li><a data-class="fa fa-language " data-index="387"><span class="fa fa-language"></span> <span class="name-class">fa fa-language</span></a></li><li><a data-class="fa fa-fax " data-index="388"><span class="fa fa-fax"></span> <span class="name-class">fa fa-fax</span></a></li><li><a data-class="fa fa-building " data-index="389"><span class="fa fa-building"></span> <span class="name-class">fa fa-building</span></a></li><li><a data-class="fa fa-child " data-index="390"><span class="fa fa-child"></span> <span class="name-class">fa fa-child</span></a></li><li><a data-class="fa fa-paw " data-index="391"><span class="fa fa-paw"></span> <span class="name-class">fa fa-paw</span></a></li><li><a data-class="fa fa-spoon " data-index="392"><span class="fa fa-spoon"></span> <span class="name-class">fa fa-spoon</span></a></li><li><a data-class="fa fa-cube " data-index="393"><span class="fa fa-cube"></span> <span class="name-class">fa fa-cube</span></a></li><li><a data-class="fa fa-cubes " data-index="394"><span class="fa fa-cubes"></span> <span class="name-class">fa fa-cubes</span></a></li><li><a data-class="fa fa-behance " data-index="395"><span class="fa fa-behance"></span> <span class="name-class">fa fa-behance</span></a></li><li><a data-class="fa fa-behance-square " data-index="396"><span class="fa fa-behance-square"></span> <span class="name-class">fa fa-behance-square</span></a></li><li><a data-class="fa fa-steam " data-index="397"><span class="fa fa-steam"></span> <span class="name-class">fa fa-steam</span></a></li><li><a data-class="fa fa-steam-square " data-index="398"><span class="fa fa-steam-square"></span> <span class="name-class">fa fa-steam-square</span></a></li><li><a data-class="fa fa-recycle " data-index="399"><span class="fa fa-recycle"></span> <span class="name-class">fa fa-recycle</span></a></li><li><a data-class="fa fa-car " data-index="400"><span class="fa fa-car"></span> <span class="name-class">fa fa-car</span></a></li><li><a data-class="fa fa-taxi " data-index="401"><span class="fa fa-taxi"></span> <span class="name-class">fa fa-taxi</span></a></li><li><a data-class="fa fa-tree " data-index="402"><span class="fa fa-tree"></span> <span class="name-class">fa fa-tree</span></a></li><li><a data-class="fa fa-spotify " data-index="403"><span class="fa fa-spotify"></span> <span class="name-class">fa fa-spotify</span></a></li><li><a data-class="fa fa-deviantart " data-index="404"><span class="fa fa-deviantart"></span> <span class="name-class">fa fa-deviantart</span></a></li><li><a data-class="fa fa-soundcloud " data-index="405"><span class="fa fa-soundcloud"></span> <span class="name-class">fa fa-soundcloud</span></a></li><li><a data-class="fa fa-database " data-index="406"><span class="fa fa-database"></span> <span class="name-class">fa fa-database</span></a></li><li><a data-class="fa fa-file-pdf-o " data-index="407"><span class="fa fa-file-pdf-o"></span> <span class="name-class">fa fa-file-pdf-o</span></a></li><li><a data-class="fa fa-file-word-o " data-index="408"><span class="fa fa-file-word-o"></span> <span class="name-class">fa fa-file-word-o</span></a></li><li><a data-class="fa fa-file-excel-o " data-index="409"><span class="fa fa-file-excel-o"></span> <span class="name-class">fa fa-file-excel-o</span></a></li><li><a data-class="fa fa-file-powerpoint-o " data-index="410"><span class="fa fa-file-powerpoint-o"></span> <span class="name-class">fa fa-file-powerpoint-o</span></a></li><li><a data-class="fa fa-file-image-o " data-index="411"><span class="fa fa-file-image-o"></span> <span class="name-class">fa fa-file-image-o</span></a></li><li><a data-class="fa fa-file-archive-o " data-index="412"><span class="fa fa-file-archive-o"></span> <span class="name-class">fa fa-file-archive-o</span></a></li><li><a data-class="fa fa-file-audio-o " data-index="413"><span class="fa fa-file-audio-o"></span> <span class="name-class">fa fa-file-audio-o</span></a></li><li><a data-class="fa fa-file-video-o " data-index="414"><span class="fa fa-file-video-o"></span> <span class="name-class">fa fa-file-video-o</span></a></li><li><a data-class="fa fa-file-code-o " data-index="415"><span class="fa fa-file-code-o"></span> <span class="name-class">fa fa-file-code-o</span></a></li><li><a data-class="fa fa-vine " data-index="416"><span class="fa fa-vine"></span> <span class="name-class">fa fa-vine</span></a></li><li><a data-class="fa fa-codepen " data-index="417"><span class="fa fa-codepen"></span> <span class="name-class">fa fa-codepen</span></a></li><li><a data-class="fa fa-jsfiddle " data-index="418"><span class="fa fa-jsfiddle"></span> <span class="name-class">fa fa-jsfiddle</span></a></li><li><a data-class="fa fa-life-ring " data-index="419"><span class="fa fa-life-ring"></span> <span class="name-class">fa fa-life-ring</span></a></li><li><a data-class="fa fa-circle-o-notch " data-index="420"><span class="fa fa-circle-o-notch"></span> <span class="name-class">fa fa-circle-o-notch</span></a></li><li><a data-class="fa fa-rebel " data-index="421"><span class="fa fa-rebel"></span> <span class="name-class">fa fa-rebel</span></a></li><li><a data-class="fa fa-empire " data-index="422"><span class="fa fa-empire"></span> <span class="name-class">fa fa-empire</span></a></li><li><a data-class="fa fa-git-square " data-index="423"><span class="fa fa-git-square"></span> <span class="name-class">fa fa-git-square</span></a></li><li><a data-class="fa fa-git " data-index="424"><span class="fa fa-git"></span> <span class="name-class">fa fa-git</span></a></li><li><a data-class="fa fa-hacker-news " data-index="425"><span class="fa fa-hacker-news"></span> <span class="name-class">fa fa-hacker-news</span></a></li><li><a data-class="fa fa-tencent-weibo " data-index="426"><span class="fa fa-tencent-weibo"></span> <span class="name-class">fa fa-tencent-weibo</span></a></li><li><a data-class="fa fa-qq " data-index="427"><span class="fa fa-qq"></span> <span class="name-class">fa fa-qq</span></a></li><li><a data-class="fa fa-weixin " data-index="428"><span class="fa fa-weixin"></span> <span class="name-class">fa fa-weixin</span></a></li><li><a data-class="fa fa-paper-plane " data-index="429"><span class="fa fa-paper-plane"></span> <span class="name-class">fa fa-paper-plane</span></a></li><li><a data-class="fa fa-paper-plane-o " data-index="430"><span class="fa fa-paper-plane-o"></span> <span class="name-class">fa fa-paper-plane-o</span></a></li><li><a data-class="fa fa-history " data-index="431"><span class="fa fa-history"></span> <span class="name-class">fa fa-history</span></a></li><li><a data-class="fa fa-circle-thin " data-index="432"><span class="fa fa-circle-thin"></span> <span class="name-class">fa fa-circle-thin</span></a></li><li><a data-class="fa fa-header " data-index="433"><span class="fa fa-header"></span> <span class="name-class">fa fa-header</span></a></li><li><a data-class="fa fa-paragraph " data-index="434"><span class="fa fa-paragraph"></span> <span class="name-class">fa fa-paragraph</span></a></li><li><a data-class="fa fa-sliders " data-index="435"><span class="fa fa-sliders"></span> <span class="name-class">fa fa-sliders</span></a></li><li><a data-class="fa fa-share-alt " data-index="436"><span class="fa fa-share-alt"></span> <span class="name-class">fa fa-share-alt</span></a></li><li><a data-class="fa fa-share-alt-square " data-index="437"><span class="fa fa-share-alt-square"></span> <span class="name-class">fa fa-share-alt-square</span></a></li><li><a data-class="fa fa-bomb " data-index="438"><span class="fa fa-bomb"></span> <span class="name-class">fa fa-bomb</span></a></li><li><a data-class="fa fa-futbol-o " data-index="439"><span class="fa fa-futbol-o"></span> <span class="name-class">fa fa-futbol-o</span></a></li><li><a data-class="fa fa-tty " data-index="440"><span class="fa fa-tty"></span> <span class="name-class">fa fa-tty</span></a></li><li><a data-class="fa fa-binoculars " data-index="441"><span class="fa fa-binoculars"></span> <span class="name-class">fa fa-binoculars</span></a></li><li><a data-class="fa fa-plug " data-index="442"><span class="fa fa-plug"></span> <span class="name-class">fa fa-plug</span></a></li><li><a data-class="fa fa-slideshare " data-index="443"><span class="fa fa-slideshare"></span> <span class="name-class">fa fa-slideshare</span></a></li><li><a data-class="fa fa-twitch " data-index="444"><span class="fa fa-twitch"></span> <span class="name-class">fa fa-twitch</span></a></li><li><a data-class="fa fa-yelp " data-index="445"><span class="fa fa-yelp"></span> <span class="name-class">fa fa-yelp</span></a></li><li><a data-class="fa fa-newspaper-o " data-index="446"><span class="fa fa-newspaper-o"></span> <span class="name-class">fa fa-newspaper-o</span></a></li><li><a data-class="fa fa-wifi " data-index="447"><span class="fa fa-wifi"></span> <span class="name-class">fa fa-wifi</span></a></li><li><a data-class="fa fa-calculator " data-index="448"><span class="fa fa-calculator"></span> <span class="name-class">fa fa-calculator</span></a></li><li><a data-class="fa fa-paypal " data-index="449"><span class="fa fa-paypal"></span> <span class="name-class">fa fa-paypal</span></a></li><li><a data-class="fa fa-google-wallet " data-index="450"><span class="fa fa-google-wallet"></span> <span class="name-class">fa fa-google-wallet</span></a></li><li><a data-class="fa fa-cc-visa " data-index="451"><span class="fa fa-cc-visa"></span> <span class="name-class">fa fa-cc-visa</span></a></li><li><a data-class="fa fa-cc-mastercard " data-index="452"><span class="fa fa-cc-mastercard"></span> <span class="name-class">fa fa-cc-mastercard</span></a></li><li><a data-class="fa fa-cc-discover " data-index="453"><span class="fa fa-cc-discover"></span> <span class="name-class">fa fa-cc-discover</span></a></li><li><a data-class="fa fa-cc-amex " data-index="454"><span class="fa fa-cc-amex"></span> <span class="name-class">fa fa-cc-amex</span></a></li><li><a data-class="fa fa-cc-paypal " data-index="455"><span class="fa fa-cc-paypal"></span> <span class="name-class">fa fa-cc-paypal</span></a></li><li><a data-class="fa fa-cc-stripe " data-index="456"><span class="fa fa-cc-stripe"></span> <span class="name-class">fa fa-cc-stripe</span></a></li><li><a data-class="fa fa-bell-slash " data-index="457"><span class="fa fa-bell-slash"></span> <span class="name-class">fa fa-bell-slash</span></a></li><li><a data-class="fa fa-bell-slash-o " data-index="458"><span class="fa fa-bell-slash-o"></span> <span class="name-class">fa fa-bell-slash-o</span></a></li><li><a data-class="fa fa-trash " data-index="459"><span class="fa fa-trash"></span> <span class="name-class">fa fa-trash</span></a></li><li><a data-class="fa fa-copyright " data-index="460"><span class="fa fa-copyright"></span> <span class="name-class">fa fa-copyright</span></a></li><li><a data-class="fa fa-at " data-index="461"><span class="fa fa-at"></span> <span class="name-class">fa fa-at</span></a></li><li><a data-class="fa fa-eyedropper " data-index="462"><span class="fa fa-eyedropper"></span> <span class="name-class">fa fa-eyedropper</span></a></li><li><a data-class="fa fa-paint-brush " data-index="463"><span class="fa fa-paint-brush"></span> <span class="name-class">fa fa-paint-brush</span></a></li><li><a data-class="fa fa-birthday-cake " data-index="464"><span class="fa fa-birthday-cake"></span> <span class="name-class">fa fa-birthday-cake</span></a></li><li><a data-class="fa fa-area-chart " data-index="465"><span class="fa fa-area-chart"></span> <span class="name-class">fa fa-area-chart</span></a></li><li><a data-class="fa fa-pie-chart " data-index="466"><span class="fa fa-pie-chart"></span> <span class="name-class">fa fa-pie-chart</span></a></li><li><a data-class="fa fa-line-chart " data-index="467"><span class="fa fa-line-chart"></span> <span class="name-class">fa fa-line-chart</span></a></li><li><a data-class="fa fa-lastfm " data-index="468"><span class="fa fa-lastfm"></span> <span class="name-class">fa fa-lastfm</span></a></li><li><a data-class="fa fa-lastfm-square " data-index="469"><span class="fa fa-lastfm-square"></span> <span class="name-class">fa fa-lastfm-square</span></a></li><li><a data-class="fa fa-toggle-off " data-index="470"><span class="fa fa-toggle-off"></span> <span class="name-class">fa fa-toggle-off</span></a></li><li><a data-class="fa fa-toggle-on " data-index="471"><span class="fa fa-toggle-on"></span> <span class="name-class">fa fa-toggle-on</span></a></li><li><a data-class="fa fa-bicycle " data-index="472"><span class="fa fa-bicycle"></span> <span class="name-class">fa fa-bicycle</span></a></li><li><a data-class="fa fa-bus " data-index="473"><span class="fa fa-bus"></span> <span class="name-class">fa fa-bus</span></a></li><li><a data-class="fa fa-ioxhost " data-index="474"><span class="fa fa-ioxhost"></span> <span class="name-class">fa fa-ioxhost</span></a></li><li><a data-class="fa fa-angellist " data-index="475"><span class="fa fa-angellist"></span> <span class="name-class">fa fa-angellist</span></a></li><li><a data-class="fa fa-cc " data-index="476"><span class="fa fa-cc"></span> <span class="name-class">fa fa-cc</span></a></li><li><a data-class="fa fa-ils " data-index="477"><span class="fa fa-ils"></span> <span class="name-class">fa fa-ils</span></a></li><li><a data-class="fa fa-meanpath " data-index="478"><span class="fa fa-meanpath"></span> <span class="name-class">fa fa-meanpath</span></a></li><li><a data-class="fa fa-buysellads " data-index="479"><span class="fa fa-buysellads"></span> <span class="name-class">fa fa-buysellads</span></a></li><li><a data-class="fa fa-connectdevelop " data-index="480"><span class="fa fa-connectdevelop"></span> <span class="name-class">fa fa-connectdevelop</span></a></li><li><a data-class="fa fa-dashcube " data-index="481"><span class="fa fa-dashcube"></span> <span class="name-class">fa fa-dashcube</span></a></li><li><a data-class="fa fa-forumbee " data-index="482"><span class="fa fa-forumbee"></span> <span class="name-class">fa fa-forumbee</span></a></li><li><a data-class="fa fa-leanpub " data-index="483"><span class="fa fa-leanpub"></span> <span class="name-class">fa fa-leanpub</span></a></li><li><a data-class="fa fa-sellsy " data-index="484"><span class="fa fa-sellsy"></span> <span class="name-class">fa fa-sellsy</span></a></li><li><a data-class="fa fa-shirtsinbulk " data-index="485"><span class="fa fa-shirtsinbulk"></span> <span class="name-class">fa fa-shirtsinbulk</span></a></li><li><a data-class="fa fa-simplybuilt " data-index="486"><span class="fa fa-simplybuilt"></span> <span class="name-class">fa fa-simplybuilt</span></a></li><li><a data-class="fa fa-skyatlas " data-index="487"><span class="fa fa-skyatlas"></span> <span class="name-class">fa fa-skyatlas</span></a></li><li><a data-class="fa fa-cart-plus " data-index="488"><span class="fa fa-cart-plus"></span> <span class="name-class">fa fa-cart-plus</span></a></li><li><a data-class="fa fa-cart-arrow-down " data-index="489"><span class="fa fa-cart-arrow-down"></span> <span class="name-class">fa fa-cart-arrow-down</span></a></li><li><a data-class="fa fa-diamond " data-index="490"><span class="fa fa-diamond"></span> <span class="name-class">fa fa-diamond</span></a></li><li><a data-class="fa fa-ship " data-index="491"><span class="fa fa-ship"></span> <span class="name-class">fa fa-ship</span></a></li><li><a data-class="fa fa-user-secret " data-index="492"><span class="fa fa-user-secret"></span> <span class="name-class">fa fa-user-secret</span></a></li><li><a data-class="fa fa-motorcycle " data-index="493"><span class="fa fa-motorcycle"></span> <span class="name-class">fa fa-motorcycle</span></a></li><li><a data-class="fa fa-street-view " data-index="494"><span class="fa fa-street-view"></span> <span class="name-class">fa fa-street-view</span></a></li><li><a data-class="fa fa-heartbeat " data-index="495"><span class="fa fa-heartbeat"></span> <span class="name-class">fa fa-heartbeat</span></a></li><li><a data-class="fa fa-venus " data-index="496"><span class="fa fa-venus"></span> <span class="name-class">fa fa-venus</span></a></li><li><a data-class="fa fa-mars " data-index="497"><span class="fa fa-mars"></span> <span class="name-class">fa fa-mars</span></a></li><li><a data-class="fa fa-mercury " data-index="498"><span class="fa fa-mercury"></span> <span class="name-class">fa fa-mercury</span></a></li><li><a data-class="fa fa-transgender " data-index="499"><span class="fa fa-transgender"></span> <span class="name-class">fa fa-transgender</span></a></li><li><a data-class="fa fa-transgender-alt " data-index="500"><span class="fa fa-transgender-alt"></span> <span class="name-class">fa fa-transgender-alt</span></a></li><li><a data-class="fa fa-venus-double " data-index="501"><span class="fa fa-venus-double"></span> <span class="name-class">fa fa-venus-double</span></a></li><li><a data-class="fa fa-mars-double " data-index="502"><span class="fa fa-mars-double"></span> <span class="name-class">fa fa-mars-double</span></a></li><li><a data-class="fa fa-venus-mars " data-index="503"><span class="fa fa-venus-mars"></span> <span class="name-class">fa fa-venus-mars</span></a></li><li><a data-class="fa fa-mars-stroke " data-index="504"><span class="fa fa-mars-stroke"></span> <span class="name-class">fa fa-mars-stroke</span></a></li><li><a data-class="fa fa-mars-stroke-v " data-index="505"><span class="fa fa-mars-stroke-v"></span> <span class="name-class">fa fa-mars-stroke-v</span></a></li><li><a data-class="fa fa-mars-stroke-h " data-index="506"><span class="fa fa-mars-stroke-h"></span> <span class="name-class">fa fa-mars-stroke-h</span></a></li><li><a data-class="fa fa-neuter " data-index="507"><span class="fa fa-neuter"></span> <span class="name-class">fa fa-neuter</span></a></li><li><a data-class="fa fa-facebook-official " data-index="508"><span class="fa fa-facebook-official"></span> <span class="name-class">fa fa-facebook-official</span></a></li><li><a data-class="fa fa-pinterest-p " data-index="509"><span class="fa fa-pinterest-p"></span> <span class="name-class">fa fa-pinterest-p</span></a></li><li><a data-class="fa fa-whatsapp " data-index="510"><span class="fa fa-whatsapp"></span> <span class="name-class">fa fa-whatsapp</span></a></li><li><a data-class="fa fa-server " data-index="511"><span class="fa fa-server"></span> <span class="name-class">fa fa-server</span></a></li><li><a data-class="fa fa-user-plus " data-index="512"><span class="fa fa-user-plus"></span> <span class="name-class">fa fa-user-plus</span></a></li><li><a data-class="fa fa-user-times " data-index="513"><span class="fa fa-user-times"></span> <span class="name-class">fa fa-user-times</span></a></li><li><a data-class="fa fa-bed " data-index="514"><span class="fa fa-bed"></span> <span class="name-class">fa fa-bed</span></a></li><li><a data-class="fa fa-viacoin " data-index="515"><span class="fa fa-viacoin"></span> <span class="name-class">fa fa-viacoin</span></a></li><li><a data-class="fa fa-train " data-index="516"><span class="fa fa-train"></span> <span class="name-class">fa fa-train</span></a></li><li><a data-class="fa fa-subway " data-index="517"><span class="fa fa-subway"></span> <span class="name-class">fa fa-subway</span></a></li><li><a data-class="fa fa-medium " data-index="518"><span class="fa fa-medium"></span> <span class="name-class">fa fa-medium</span></a></li></ul>
				</div>
        		<input type="hidden" class="edit_faicon_element">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
				<button type="button" id="edit_faicon_btn" class="btn btn-success">
					<i class="fa fa-check-circle-o"></i>
					Use Selected Icon
				</button>
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

	.icon-picker-list {
		display: flex;
		flex-flow: row wrap;
		list-style: none;
		padding-left: 0;
	}

	.icon-picker-list li {
		display: flex;
		flex: 0 0 20%;
		float: left;
		width: 20%;
	}

	.icon-picker-list a {
		background-color: #f9f9f9;
		border: 1px solid #fff;
		color: black;
		display: block;
		flex: 1 1 auto;
		font-size: 12px;
		line-height: 1.4;
		min-height: 100px;
		padding: 10px;
		text-align: center;
		user-select: none;
	}

	.icon-picker-list a:hover,
	.icon-picker-list a.active{
		background-color: #009E49;
		color: #fff;
		cursor: pointer;
		text-decoration: none;
	}

	.icon-picker-list .fa {
		font-size: 24px;
		margin-bottom: 10px;
		margin-top: 5px;
	}

	.icon-picker-list .name-class {
		display: block;
		text-align: center;
		word-wrap: break-word;
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('scripts')
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
			$('.lfm_input').filemanager('image', {prefix: domain});

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

			function replaceContent (el, content) {
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").html(content);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").html(content);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
			}


			iframe.find('.pageblock_body [data-type="image"]').hover(
			       function(){ $(this).addClass('pb_element_img_hover') },
			       function(){ $(this).removeClass('pb_element_img_hover') }
			);
			iframe.find('.pageblock_body img[data-type="image"]').each(function(){
				var content = $(this).attr('src');
			  	$(this).click(function (event) {
			  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
					$(this).attr('data-unique', el);
					var alttext = $(this).attr('alt');
					var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
					$(this).attr('data-pbid', pbid);
					var eltype = $(this).prop('nodeName');
					var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
					iframe.find("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			  		$('input.edit_image_value').val(content);
			  		$('input.edit_image_element').val(el);
			  		$('input.edit_image_alt_value').val(alttext);
			  		$('input.edit_image_element').attr('data-pbid', pbid);
			  		$('img#holder').attr('src', content);
			        $('#modal_image_editor').modal('show');
			    });
			});
			$('#edit_image_btn').click(function (event) {
				var el = $('input.edit_image_element').val();
				var content = $('#edit_image_value').val();
				var alt = $('input.edit_image_alt_value').val();
				var pbid = $('input.edit_image_element').attr('data-pbid');
				//console.log('da vall:: ', window.location.protocol + '//' + window.location.hostname + content);
				replaceImage(el, content, alt);
				iframe.find('.pb_control_save[data-id='+pbid+']').removeClass('not_shown');
				iframe.find('.pb_control_save[data-id='+pbid+']').addClass('shown');
				$('#modal_image_editor').modal('hide');
			});

			function replaceImage (el, content, alt) {
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('src', window.location.protocol + '//' + window.location.hostname + content);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('alt', alt);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('src', '[%URL%]' + content);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('alt', alt);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
			}






			iframe.find('.pageblock_body a').each(function(){
			  	$(this).click(function (event) {
			  		event.preventDefault();
			    });
			});
			iframe.find('.pageblock_body a[data-type="link"]').hover(
			       function(){ $(this).addClass('pb_element_link_hover') },
			       function(){ $(this).removeClass('pb_element_link_hover') }
			);
			iframe.find('.pageblock_body a[data-type="link"]').each(function(){
			  	$(this).click(function (event) {
			  		event.preventDefault();
			  		var content = $(this).html();
			  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
			  		
			  		var hrefval = $(this).attr('href');
			  		var classval = $(this).attr('class');
			  		var styleval = $(this).attr('style');
            var targetval = $(this).attr('target');

					$(this).attr('data-unique', el);
					var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
					$(this).attr('data-pbid', pbid);
					var eltype = $(this).prop('nodeName');
					var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
					iframe.find("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			  		$('#link_edit_value').val(content);
			  		$('input.link_edit_element').val(el);
			  		$('input.link_edit_element').attr('data-pbid', pbid);
			  		$('#link_edit_href_value').val(hrefval);
			  		$('#link_edit_class_value').val(classval);
			  		$('#link_edit_style_value').val(styleval);
            $('#link_edit_target_value').val(targetval);
			        $('#modal_link_editor').modal('show');
			    });
			});
			$('#edit_link_btn').click(function (event) {
				var el = $('input.link_edit_element').val();
				var content = $('#link_edit_value').val();
				var pbid = $('input.link_edit_element').attr('data-pbid');
				var hrefval = $('#link_edit_href_value').val();
		  		var classval = $('#link_edit_class_value').val();
		  		var styleval = $('#link_edit_style_value').val();
          var targetval = $('#link_edit_target_value').val();
				replaceLink(el, content, hrefval, classval, styleval, targetval);
				iframe.find('.pb_control_save[data-id='+pbid+']').removeClass('not_shown');
				iframe.find('.pb_control_save[data-id='+pbid+']').addClass('shown');
				$('#modal_link_editor').modal('hide');
			});

			function replaceLink (el, content, hrefval, classval, styleval, targetval) {
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").html(content);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('href', hrefval);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('class', classval);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('style', styleval);
        iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('target', targetval);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").html(content);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('href', hrefval);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('class', classval);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('style', styleval);
        iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('target', targetval);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
			}




			iframe.find('[data-type="background"]').hover(
			       function(){ $(this).addClass('pb_element_bg_hover') },
			       function(){ $(this).removeClass('pb_element_bg_hover') }
			);
			iframe.find('.pageblock_body [data-type="background"]').each(function(){
			  	$(this).click(function (event) {
			  		var bg = $(this).css('background-image');
			  		bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
			  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
					$(this).attr('data-unique', el);
					var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
					$(this).attr('data-pbid', pbid);
					var eltype = $(this).prop('nodeName');
					var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
					iframe.find("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			  		$('input.edit_background_value').val(bg);
			  		$('input.edit_background_element').val(el);
			  		$('input.edit_background_element').attr('data-pbid', pbid);
			  		$('img#backgroundholder').attr('src', bg);
			        $('#modal_background_editor').modal('show');
			    });
			});
			$('#edit_background_btn').click(function (event) {
				var el = $('input.edit_background_element').val();
				var content = $('#edit_background_value').val();
				var pbid = $('input.edit_background_element').attr('data-pbid');
				//console.log('da vall:: ', window.location.protocol + '//' + window.location.hostname + content);
				replaceBackground(el, content);
				iframe.find('.pb_control_save[data-id='+pbid+']').removeClass('not_shown');
				iframe.find('.pb_control_save[data-id='+pbid+']').addClass('shown');
				$('#modal_background_editor').modal('hide');
			});

			function replaceBackground (el, content) {
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").css('background-image', 'url(' + window.location.protocol + '//' + window.location.hostname + content + ')');
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');

				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").css('background-image', 'url(' + '[%URL%]' + content + ')');
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
			}











			

			var icons = [{ icon: 'fa fa-glass' }, { icon: 'fa fa-music' }, { icon: 'fa fa-search' }, { icon: 'fa fa-envelope-o' }, { icon: 'fa fa-heart' }, { icon: 'fa fa-star' }, { icon: 'fa fa-star-o' }, { icon: 'fa fa-user' }, { icon: 'fa fa-film' }, { icon: 'fa fa-th-large' }, { icon: 'fa fa-th' }, { icon: 'fa fa-th-list' }, { icon: 'fa fa-check' }, { icon: 'fa fa-times' }, { icon: 'fa fa-search-plus' }, { icon: 'fa fa-search-minus' }, { icon: 'fa fa-power-off' }, { icon: 'fa fa-signal' }, { icon: 'fa fa-cog' }, { icon: 'fa fa-trash-o' }, { icon: 'fa fa-home' }, { icon: 'fa fa-file-o' }, { icon: 'fa fa-clock-o' }, { icon: 'fa fa-road' }, { icon: 'fa fa-download' }, { icon: 'fa fa-arrow-circle-o-down' }, { icon: 'fa fa-arrow-circle-o-up' }, { icon: 'fa fa-inbox' }, { icon: 'fa fa-play-circle-o' }, { icon: 'fa fa-repeat' }, { icon: 'fa fa-refresh' }, { icon: 'fa fa-list-alt' }, { icon: 'fa fa-lock' }, { icon: 'fa fa-flag' }, { icon: 'fa fa-headphones' }, { icon: 'fa fa-volume-off' }, { icon: 'fa fa-volume-down' }, { icon: 'fa fa-volume-up' }, { icon: 'fa fa-qrcode' }, { icon: 'fa fa-barcode' }, { icon: 'fa fa-tag' }, { icon: 'fa fa-tags' }, { icon: 'fa fa-book' }, { icon: 'fa fa-bookmark' }, { icon: 'fa fa-print' }, { icon: 'fa fa-camera' }, { icon: 'fa fa-font' }, { icon: 'fa fa-bold' }, { icon: 'fa fa-italic' }, { icon: 'fa fa-text-height' }, { icon: 'fa fa-text-width' }, { icon: 'fa fa-align-left' }, { icon: 'fa fa-align-center' }, { icon: 'fa fa-align-right' }, { icon: 'fa fa-align-justify' }, { icon: 'fa fa-list' }, { icon: 'fa fa-outdent' }, { icon: 'fa fa-indent' }, { icon: 'fa fa-video-camera' }, { icon: 'fa fa-picture-o' }, { icon: 'fa fa-pencil' }, { icon: 'fa fa-map-marker' }, { icon: 'fa fa-adjust' }, { icon: 'fa fa-tint' }, { icon: 'fa fa-pencil-square-o' }, { icon: 'fa fa-share-square-o' }, { icon: 'fa fa-check-square-o' }, { icon: 'fa fa-arrows' }, { icon: 'fa fa-step-backward' }, { icon: 'fa fa-fast-backward' }, { icon: 'fa fa-backward' }, { icon: 'fa fa-play' }, { icon: 'fa fa-pause' }, { icon: 'fa fa-stop' }, { icon: 'fa fa-forward' }, { icon: 'fa fa-fast-forward' }, { icon: 'fa fa-step-forward' }, { icon: 'fa fa-eject' }, { icon: 'fa fa-chevron-left' }, { icon: 'fa fa-chevron-right' }, { icon: 'fa fa-plus-circle' }, { icon: 'fa fa-minus-circle' }, { icon: 'fa fa-times-circle' }, { icon: 'fa fa-check-circle' }, { icon: 'fa fa-question-circle' }, { icon: 'fa fa-info-circle' }, { icon: 'fa fa-crosshairs' }, { icon: 'fa fa-times-circle-o' }, { icon: 'fa fa-check-circle-o' }, { icon: 'fa fa-ban' }, { icon: 'fa fa-arrow-left' }, { icon: 'fa fa-arrow-right' }, { icon: 'fa fa-arrow-up' }, { icon: 'fa fa-arrow-down' }, { icon: 'fa fa-share' }, { icon: 'fa fa-expand' }, { icon: 'fa fa-compress' }, { icon: 'fa fa-plus' }, { icon: 'fa fa-minus' }, { icon: 'fa fa-asterisk' }, { icon: 'fa fa-exclamation-circle' }, { icon: 'fa fa-gift' }, { icon: 'fa fa-leaf' }, { icon: 'fa fa-fire' }, { icon: 'fa fa-eye' }, { icon: 'fa fa-eye-slash' }, { icon: 'fa fa-exclamation-triangle' }, { icon: 'fa fa-plane' }, { icon: 'fa fa-calendar' }, { icon: 'fa fa-random' }, { icon: 'fa fa-comment' }, { icon: 'fa fa-magnet' }, { icon: 'fa fa-chevron-up' }, { icon: 'fa fa-chevron-down' }, { icon: 'fa fa-retweet' }, { icon: 'fa fa-shopping-cart' }, { icon: 'fa fa-folder' }, { icon: 'fa fa-folder-open' }, { icon: 'fa fa-arrows-v' }, { icon: 'fa fa-arrows-h' }, { icon: 'fa fa-bar-chart' }, { icon: 'fa fa-twitter-square' }, { icon: 'fa fa-facebook-square' }, { icon: 'fa fa-camera-retro' }, { icon: 'fa fa-key' }, { icon: 'fa fa-cogs' }, { icon: 'fa fa-comments' }, { icon: 'fa fa-thumbs-o-up' }, { icon: 'fa fa-thumbs-o-down' }, { icon: 'fa fa-star-half' }, { icon: 'fa fa-heart-o' }, { icon: 'fa fa-sign-out' }, { icon: 'fa fa-linkedin-square' }, { icon: 'fa fa-thumb-tack' }, { icon: 'fa fa-external-link' }, { icon: 'fa fa-sign-in' }, { icon: 'fa fa-trophy' }, { icon: 'fa fa-github-square' }, { icon: 'fa fa-upload' }, { icon: 'fa fa-lemon-o' }, { icon: 'fa fa-phone' }, { icon: 'fa fa-square-o' }, { icon: 'fa fa-bookmark-o' }, { icon: 'fa fa-phone-square' }, { icon: 'fa fa-twitter' }, { icon: 'fa fa-facebook' }, { icon: 'fa fa-github' }, { icon: 'fa fa-unlock' }, { icon: 'fa fa-credit-card' }, { icon: 'fa fa-rss' }, { icon: 'fa fa-hdd-o' }, { icon: 'fa fa-bullhorn' }, { icon: 'fa fa-bell' }, { icon: 'fa fa-certificate' }, { icon: 'fa fa-hand-o-right' }, { icon: 'fa fa-hand-o-left' }, { icon: 'fa fa-hand-o-up' }, { icon: 'fa fa-hand-o-down' }, { icon: 'fa fa-arrow-circle-left' }, { icon: 'fa fa-arrow-circle-right' }, { icon: 'fa fa-arrow-circle-up' }, { icon: 'fa fa-arrow-circle-down' }, { icon: 'fa fa-globe' }, { icon: 'fa fa-wrench' }, { icon: 'fa fa-tasks' }, { icon: 'fa fa-filter' }, { icon: 'fa fa-briefcase' }, { icon: 'fa fa-arrows-alt' }, { icon: 'fa fa-users' }, { icon: 'fa fa-link' }, { icon: 'fa fa-cloud' }, { icon: 'fa fa-flask' }, { icon: 'fa fa-scissors' }, { icon: 'fa fa-files-o' }, { icon: 'fa fa-paperclip' }, { icon: 'fa fa-floppy-o' }, { icon: 'fa fa-square' }, { icon: 'fa fa-bars' }, { icon: 'fa fa-list-ul' }, { icon: 'fa fa-list-ol' }, { icon: 'fa fa-strikethrough' }, { icon: 'fa fa-underline' }, { icon: 'fa fa-table' }, { icon: 'fa fa-magic' }, { icon: 'fa fa-truck' }, { icon: 'fa fa-pinterest' }, { icon: 'fa fa-pinterest-square' }, { icon: 'fa fa-google-plus-square' }, { icon: 'fa fa-google-plus' }, { icon: 'fa fa-money' }, { icon: 'fa fa-caret-down' }, { icon: 'fa fa-caret-up' }, { icon: 'fa fa-caret-left' }, { icon: 'fa fa-caret-right' }, { icon: 'fa fa-columns' }, { icon: 'fa fa-sort' }, { icon: 'fa fa-sort-desc' }, { icon: 'fa fa-sort-asc' }, { icon: 'fa fa-envelope' }, { icon: 'fa fa-linkedin' }, { icon: 'fa fa-undo' }, { icon: 'fa fa-gavel' }, { icon: 'fa fa-tachometer' }, { icon: 'fa fa-comment-o' }, { icon: 'fa fa-comments-o' }, { icon: 'fa fa-bolt' }, { icon: 'fa fa-sitemap' }, { icon: 'fa fa-umbrella' }, { icon: 'fa fa-clipboard' }, { icon: 'fa fa-lightbulb-o' }, { icon: 'fa fa-exchange' }, { icon: 'fa fa-cloud-download' }, { icon: 'fa fa-cloud-upload' }, { icon: 'fa fa-user-md' }, { icon: 'fa fa-stethoscope' }, { icon: 'fa fa-suitcase' }, { icon: 'fa fa-bell-o' }, { icon: 'fa fa-coffee' }, { icon: 'fa fa-cutlery' }, { icon: 'fa fa-file-text-o' }, { icon: 'fa fa-building-o' }, { icon: 'fa fa-hospital-o' }, { icon: 'fa fa-ambulance' }, { icon: 'fa fa-medkit' }, { icon: 'fa fa-fighter-jet' }, { icon: 'fa fa-beer' }, { icon: 'fa fa-h-square' }, { icon: 'fa fa-plus-square' }, { icon: 'fa fa-angle-double-left' }, { icon: 'fa fa-angle-double-right' }, { icon: 'fa fa-angle-double-up' }, { icon: 'fa fa-angle-double-down' }, { icon: 'fa fa-angle-left' }, { icon: 'fa fa-angle-right' }, { icon: 'fa fa-angle-up' }, { icon: 'fa fa-angle-down' }, { icon: 'fa fa-desktop' }, { icon: 'fa fa-laptop' }, { icon: 'fa fa-tablet' }, { icon: 'fa fa-mobile' }, { icon: 'fa fa-circle-o' }, { icon: 'fa fa-quote-left' }, { icon: 'fa fa-quote-right' }, { icon: 'fa fa-spinner' }, { icon: 'fa fa-circle' }, { icon: 'fa fa-reply' }, { icon: 'fa fa-github-alt' }, { icon: 'fa fa-folder-o' }, { icon: 'fa fa-folder-open-o' }, { icon: 'fa fa-smile-o' }, { icon: 'fa fa-frown-o' }, { icon: 'fa fa-meh-o' }, { icon: 'fa fa-gamepad' }, { icon: 'fa fa-keyboard-o' }, { icon: 'fa fa-flag-o' }, { icon: 'fa fa-flag-checkered' }, { icon: 'fa fa-terminal' }, { icon: 'fa fa-code' }, { icon: 'fa fa-reply-all' }, { icon: 'fa fa-star-half-o' }, { icon: 'fa fa-location-arrow' }, { icon: 'fa fa-crop' }, { icon: 'fa fa-code-fork' }, { icon: 'fa fa-chain-broken' }, { icon: 'fa fa-question' }, { icon: 'fa fa-info' }, { icon: 'fa fa-exclamation' }, { icon: 'fa fa-superscript' }, { icon: 'fa fa-subscript' }, { icon: 'fa fa-eraser' }, { icon: 'fa fa-puzzle-piece' }, { icon: 'fa fa-microphone' }, { icon: 'fa fa-microphone-slash' }, { icon: 'fa fa-shield' }, { icon: 'fa fa-calendar-o' }, { icon: 'fa fa-fire-extinguisher' }, { icon: 'fa fa-rocket' }, { icon: 'fa fa-maxcdn' }, { icon: 'fa fa-chevron-circle-left' }, { icon: 'fa fa-chevron-circle-right' }, { icon: 'fa fa-chevron-circle-up' }, { icon: 'fa fa-chevron-circle-down' }, { icon: 'fa fa-html5' }, { icon: 'fa fa-css3' }, { icon: 'fa fa-anchor' }, { icon: 'fa fa-unlock-alt' }, { icon: 'fa fa-bullseye' }, { icon: 'fa fa-ellipsis-h' }, { icon: 'fa fa-ellipsis-v' }, { icon: 'fa fa-rss-square' }, { icon: 'fa fa-play-circle' }, { icon: 'fa fa-ticket' }, { icon: 'fa fa-minus-square' }, { icon: 'fa fa-minus-square-o' }, { icon: 'fa fa-level-up' }, { icon: 'fa fa-level-down' }, { icon: 'fa fa-check-square' }, { icon: 'fa fa-pencil-square' }, { icon: 'fa fa-external-link-square' }, { icon: 'fa fa-share-square' }, { icon: 'fa fa-compass' }, { icon: 'fa fa-caret-square-o-down' }, { icon: 'fa fa-caret-square-o-up' }, { icon: 'fa fa-caret-square-o-right' }, { icon: 'fa fa-eur' }, { icon: 'fa fa-gbp' }, { icon: 'fa fa-usd' }, { icon: 'fa fa-inr' }, { icon: 'fa fa-jpy' }, { icon: 'fa fa-rub' }, { icon: 'fa fa-krw' }, { icon: 'fa fa-btc' }, { icon: 'fa fa-file' }, { icon: 'fa fa-file-text' }, { icon: 'fa fa-sort-alpha-asc' }, { icon: 'fa fa-sort-alpha-desc' }, { icon: 'fa fa-sort-amount-asc' }, { icon: 'fa fa-sort-amount-desc' }, { icon: 'fa fa-sort-numeric-asc' }, { icon: 'fa fa-sort-numeric-desc' }, { icon: 'fa fa-thumbs-up' }, { icon: 'fa fa-thumbs-down' }, { icon: 'fa fa-youtube-square' }, { icon: 'fa fa-youtube' }, { icon: 'fa fa-xing' }, { icon: 'fa fa-xing-square' }, { icon: 'fa fa-youtube-play' }, { icon: 'fa fa-dropbox' }, { icon: 'fa fa-stack-overflow' }, { icon: 'fa fa-instagram' }, { icon: 'fa fa-flickr' }, { icon: 'fa fa-adn' }, { icon: 'fa fa-bitbucket' }, { icon: 'fa fa-bitbucket-square' }, { icon: 'fa fa-tumblr' }, { icon: 'fa fa-tumblr-square' }, { icon: 'fa fa-long-arrow-down' }, { icon: 'fa fa-long-arrow-up' }, { icon: 'fa fa-long-arrow-left' }, { icon: 'fa fa-long-arrow-right' }, { icon: 'fa fa-apple' }, { icon: 'fa fa-windows' }, { icon: 'fa fa-android' }, { icon: 'fa fa-linux' }, { icon: 'fa fa-dribbble' }, { icon: 'fa fa-skype' }, { icon: 'fa fa-foursquare' }, { icon: 'fa fa-trello' }, { icon: 'fa fa-female' }, { icon: 'fa fa-male' }, { icon: 'fa fa-gratipay' }, { icon: 'fa fa-sun-o' }, { icon: 'fa fa-moon-o' }, { icon: 'fa fa-archive' }, { icon: 'fa fa-bug' }, { icon: 'fa fa-vk' }, { icon: 'fa fa-weibo' }, { icon: 'fa fa-renren' }, { icon: 'fa fa-pagelines' }, { icon: 'fa fa-stack-exchange' }, { icon: 'fa fa-arrow-circle-o-right' }, { icon: 'fa fa-arrow-circle-o-left' }, { icon: 'fa fa-caret-square-o-left' }, { icon: 'fa fa-dot-circle-o' }, { icon: 'fa fa-wheelchair' }, { icon: 'fa fa-vimeo-square' }, { icon: 'fa fa-try' }, { icon: 'fa fa-plus-square-o' }, { icon: 'fa fa-space-shuttle' }, { icon: 'fa fa-slack' }, { icon: 'fa fa-envelope-square' }, { icon: 'fa fa-wordpress' }, { icon: 'fa fa-openid' }, { icon: 'fa fa-university' }, { icon: 'fa fa-graduation-cap' }, { icon: 'fa fa-yahoo' }, { icon: 'fa fa-google' }, { icon: 'fa fa-reddit' }, { icon: 'fa fa-reddit-square' }, { icon: 'fa fa-stumbleupon-circle' }, { icon: 'fa fa-stumbleupon' }, { icon: 'fa fa-delicious' }, { icon: 'fa fa-digg' }, { icon: 'fa fa-pied-piper' }, { icon: 'fa fa-pied-piper-alt' }, { icon: 'fa fa-drupal' }, { icon: 'fa fa-joomla' }, { icon: 'fa fa-language' }, { icon: 'fa fa-fax' }, { icon: 'fa fa-building' }, { icon: 'fa fa-child' }, { icon: 'fa fa-paw' }, { icon: 'fa fa-spoon' }, { icon: 'fa fa-cube' }, { icon: 'fa fa-cubes' }, { icon: 'fa fa-behance' }, { icon: 'fa fa-behance-square' }, { icon: 'fa fa-steam' }, { icon: 'fa fa-steam-square' }, { icon: 'fa fa-recycle' }, { icon: 'fa fa-car' }, { icon: 'fa fa-taxi' }, { icon: 'fa fa-tree' }, { icon: 'fa fa-spotify' }, { icon: 'fa fa-deviantart' }, { icon: 'fa fa-soundcloud' }, { icon: 'fa fa-database' }, { icon: 'fa fa-file-pdf-o' }, { icon: 'fa fa-file-word-o' }, { icon: 'fa fa-file-excel-o' }, { icon: 'fa fa-file-powerpoint-o' }, { icon: 'fa fa-file-image-o' }, { icon: 'fa fa-file-archive-o' }, { icon: 'fa fa-file-audio-o' }, { icon: 'fa fa-file-video-o' }, { icon: 'fa fa-file-code-o' }, { icon: 'fa fa-vine' }, { icon: 'fa fa-codepen' }, { icon: 'fa fa-jsfiddle' }, { icon: 'fa fa-life-ring' }, { icon: 'fa fa-circle-o-notch' }, { icon: 'fa fa-rebel' }, { icon: 'fa fa-empire' }, { icon: 'fa fa-git-square' }, { icon: 'fa fa-git' }, { icon: 'fa fa-hacker-news' }, { icon: 'fa fa-tencent-weibo' }, { icon: 'fa fa-qq' }, { icon: 'fa fa-weixin' }, { icon: 'fa fa-paper-plane' }, { icon: 'fa fa-paper-plane-o' }, { icon: 'fa fa-history' }, { icon: 'fa fa-circle-thin' }, { icon: 'fa fa-header' }, { icon: 'fa fa-paragraph' }, { icon: 'fa fa-sliders' }, { icon: 'fa fa-share-alt' }, { icon: 'fa fa-share-alt-square' }, { icon: 'fa fa-bomb' }, { icon: 'fa fa-futbol-o' }, { icon: 'fa fa-tty' }, { icon: 'fa fa-binoculars' }, { icon: 'fa fa-plug' }, { icon: 'fa fa-slideshare' }, { icon: 'fa fa-twitch' }, { icon: 'fa fa-yelp' }, { icon: 'fa fa-newspaper-o' }, { icon: 'fa fa-wifi' }, { icon: 'fa fa-calculator' }, { icon: 'fa fa-paypal' }, { icon: 'fa fa-google-wallet' }, { icon: 'fa fa-cc-visa' }, { icon: 'fa fa-cc-mastercard' }, { icon: 'fa fa-cc-discover' }, { icon: 'fa fa-cc-amex' }, { icon: 'fa fa-cc-paypal' }, { icon: 'fa fa-cc-stripe' }, { icon: 'fa fa-bell-slash' }, { icon: 'fa fa-bell-slash-o' }, { icon: 'fa fa-trash' }, { icon: 'fa fa-copyright' }, { icon: 'fa fa-at' }, { icon: 'fa fa-eyedropper' }, { icon: 'fa fa-paint-brush' }, { icon: 'fa fa-birthday-cake' }, { icon: 'fa fa-area-chart' }, { icon: 'fa fa-pie-chart' }, { icon: 'fa fa-line-chart' }, { icon: 'fa fa-lastfm' }, { icon: 'fa fa-lastfm-square' }, { icon: 'fa fa-toggle-off' }, { icon: 'fa fa-toggle-on' }, { icon: 'fa fa-bicycle' }, { icon: 'fa fa-bus' }, { icon: 'fa fa-ioxhost' }, { icon: 'fa fa-angellist' }, { icon: 'fa fa-cc' }, { icon: 'fa fa-ils' }, { icon: 'fa fa-meanpath' }, { icon: 'fa fa-buysellads' }, { icon: 'fa fa-connectdevelop' }, { icon: 'fa fa-dashcube' }, { icon: 'fa fa-forumbee' }, { icon: 'fa fa-leanpub' }, { icon: 'fa fa-sellsy' }, { icon: 'fa fa-shirtsinbulk' }, { icon: 'fa fa-simplybuilt' }, { icon: 'fa fa-skyatlas' }, { icon: 'fa fa-cart-plus' }, { icon: 'fa fa-cart-arrow-down' }, { icon: 'fa fa-diamond' }, { icon: 'fa fa-ship' }, { icon: 'fa fa-user-secret' }, { icon: 'fa fa-motorcycle' }, { icon: 'fa fa-street-view' }, { icon: 'fa fa-heartbeat' }, { icon: 'fa fa-venus' }, { icon: 'fa fa-mars' }, { icon: 'fa fa-mercury' }, { icon: 'fa fa-transgender' }, { icon: 'fa fa-transgender-alt' }, { icon: 'fa fa-venus-double' }, { icon: 'fa fa-mars-double' }, { icon: 'fa fa-venus-mars' }, { icon: 'fa fa-mars-stroke' }, { icon: 'fa fa-mars-stroke-v' }, { icon: 'fa fa-mars-stroke-h' }, { icon: 'fa fa-neuter' }, { icon: 'fa fa-facebook-official' }, { icon: 'fa fa-pinterest-p' }, { icon: 'fa fa-whatsapp' }, { icon: 'fa fa-server' }, { icon: 'fa fa-user-plus' }, { icon: 'fa fa-user-times' }, { icon: 'fa fa-bed' }, { icon: 'fa fa-viacoin' }, { icon: 'fa fa-train' }, { icon: 'fa fa-subway' }, { icon: 'fa fa-medium' }];

			var itemTemplate = $('.icon-picker-list').clone(true).html();

			// $('.icon-picker-list').html('');

			// // Loop through JSON and appends content to show icons
			// $(icons).each(function(index) {
			// 	var itemtemp = itemTemplate;
			// 	var item = icons[index].icon;

			// 	if (index == selectedIcon) {
			// 		var activeState = 'active'
			// 	} else {
			// 		var activeState = ''
			// 	}

			// 	itemtemp = itemtemp.replace(/{item}/g, item).replace(/{index}/g, index).replace(/{activeState}/g, activeState);
				
			// 	$('.icon-picker-list').append(itemtemp);
			// });

			iframe.find('[data-type="faicon"]').hover(
		       function(){ $(this).addClass('pb_element_icon_hover') },
		       function(){ $(this).removeClass('pb_element_icon_hover') }
			);
			// Variable that's passed around for active states of icons
			var selectedIcon = null;
			iframe.find('.pageblock_body [data-type="faicon"]').each(function(){
			  	$(this).click(function (event) {
			  		var fa = $(this).attr('class');
			  		var res = fa.split('fa-').pop().split(' ').shift();
			  		fa = 'fa-'+res;
			  		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
					$(this).attr('data-unique', el);
					var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
					$(this).attr('data-pbid', pbid);
					var eltype = $(this).prop('nodeName');
					var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
					iframe.find("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			  		$('input.edit_faicon_element').val(el);
			  		$('input.edit_faicon_element').attr('data-pbid', pbid);
			  		$('input.edit_faicon_element').attr('data-oldicon', fa);
			        $('#modal_faicon_editor').modal('show');
			        // Sets active state by looping through the list with the previous class from the picker input
					selectedIcon = findInObject(icons, 'icon', fa);
					// Removes any previous active class
					$('.icon-picker-list a').removeClass('active');
					// Sets active class
					$('.icon-picker-list a').eq(selectedIcon).addClass('active');
			    });
			});
			// Click function to select icon / update active icon
			$(document).on('click', '.icon-picker-list a', function() {
				// Sets selected icon
				selectedIcon = $(this).data('index');
				// Removes any previous active class
				$('.icon-picker-list a').removeClass('active');
				// Sets active class
				$('.icon-picker-list a').eq(selectedIcon).addClass('active');
			});
			$('#edit_faicon_btn').click(function (event) {
				var el = $('input.edit_faicon_element').val();
				var content = icons[selectedIcon].icon;
				var oldicon = $('input.edit_faicon_element').attr('data-oldicon');
				var pbid = $('input.edit_faicon_element').attr('data-pbid');
				//console.log('da vall:: ', window.location.protocol + '//' + window.location.hostname + content);
				replaceIcon(el, content, oldicon);
				iframe.find('.pb_control_save[data-id='+pbid+']').removeClass('not_shown');
				iframe.find('.pb_control_save[data-id='+pbid+']').addClass('shown');
				$('#modal_faicon_editor').modal('hide');
			});

			function replaceIcon (el, content, oldicon) {
				elclass = iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('class');
				newcontent = content.replace('fa ', '');
				newclass = elclass.replace(oldicon, newcontent);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('class', newclass);
				iframe.find('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('class', newclass);
				iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
			}

			function findInObject(object, property, value) {
				for (var i = 0; i < object.length; i += 1) {
					if (object[i][property] === value) {
						return i;
					}
				}
			}



			//var slicons = [{ slicon: 'icon-line-eye' },{ slicon: 'icon-line2-handbag' },{ slicon: 'icon-line-search' },{ slicon: 'icon-line-bar-graph' },{ slicon: 'icon-line-paper-clip' },{ slicon: 'icon-line2-briefcase' },{ slicon: 'icon-line-zoom-in' },{ slicon: 'icon-line-pie-graph' },{ slicon: 'icon-line-mail' },{ slicon: 'icon-line2-book-open' },{ slicon: 'icon-line-zoom-out' },{ slicon: 'icon-line-star' },{ slicon: 'icon-line-toggle' },{ slicon: 'icon-line2-basket-loaded' },{ slicon: 'icon-line-reply' },{ slicon: 'icon-line-arrow-left' },{ slicon: 'icon-line-layout' },{ slicon: 'icon-line2-basket' },{ slicon: 'icon-line-circle-plus' },{ slicon: 'icon-line-arrow-right' },{ slicon: 'icon-line-link' },{ slicon: 'icon-line2-bag' },{ slicon: 'icon-line-circle-minus' },{ slicon: 'icon-line-arrow-up' },{ slicon: 'icon-line-bell' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },{ slicon: 'icon' },];

			// var slitemTemplate = $('.slicon-picker-list').clone(true).html();

			// $('.slicon-picker-list').html('');

			// // Loop through JSON and appends content to show icons
			// $(slicons).each(function(index) {
			// 	var itemtemp = slitemTemplate;
			// 	var item = slicons[index].slicon;

			// 	if (index == selectedIcon) {
			// 		var activeState = 'active'
			// 	} else {
			// 		var activeState = ''
			// 	}

			// 	itemtemp = itemtemp.replace(/[{%item%}]/g, item).replace(/[{%index%}]/g, index).replace(/[{%activeState%}]/g, activeState);
				
			// 	$('.icon-picker-list').append(itemtemp);
			// });

			// iframe.find('[data-type="faicon"]').hover(
		 //       function(){ $(this).addClass('pb_element_icon_hover') },
		 //       function(){ $(this).removeClass('pb_element_icon_hover') }
			// );
			// // Variable that's passed around for active states of icons
			// var selectedIcon = null;
			// iframe.find('.pageblock_body [data-type="faicon"]').each(function(){
			//   	$(this).click(function (event) {
			//   		var fa = $(this).attr('class');
			//   		var res = fa.match(/.*[\ \"\']+(fa-[a-zA-z0-9]*).*/);
			//   		fa = res[1];
			//   		var el = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 12);
			// 		$(this).attr('data-unique', el);
			// 		var pbid = $(this).parents( ".pageblock_body" ).attr('data-pbid');
			// 		$(this).attr('data-pbid', pbid);
			// 		var eltype = $(this).prop('nodeName');
			// 		var index = $(this).closest("#pageblock_body_"+pbid+"").find(eltype).index(this);
			// 		iframe.find("#pageblock_body_raw_"+pbid+" "+eltype+"").eq(index).attr('data-unique', el);
			//   		$('input.edit_faicon_element').val(el);
			//   		$('input.edit_faicon_element').attr('data-pbid', pbid);
			//   		$('input.edit_faicon_element').attr('data-oldicon', fa);
			//         $('#modal_faicon_editor').modal('show');
			//         // Sets active state by looping through the list with the previous class from the picker input
			// 		selectedIcon = findInObject(icons, 'icon', fa);
			// 		// Removes any previous active class
			// 		$('.icon-picker-list a').removeClass('active');
			// 		// Sets active class
			// 		$('.icon-picker-list a').eq(selectedIcon).addClass('active');
			//     });
			// });
			// // Click function to select icon / update active icon
			// $(document).on('click', '.icon-picker-list a', function() {
			// 	// Sets selected icon
			// 	selectedIcon = $(this).data('index');
			// 	// Removes any previous active class
			// 	$('.icon-picker-list a').removeClass('active');
			// 	// Sets active class
			// 	$('.icon-picker-list a').eq(selectedIcon).addClass('active');
			// });
			// $('#edit_faicon_btn').click(function (event) {
			// 	var el = $('input.edit_faicon_element').val();
			// 	var content = icons[selectedIcon].icon;
			// 	var oldicon = $('input.edit_faicon_element').attr('data-oldicon');
			// 	var pbid = $('input.edit_faicon_element').attr('data-pbid');
			// 	//console.log('da vall:: ', window.location.protocol + '//' + window.location.hostname + content);
			// 	replaceIcon(el, content, oldicon);
			// 	iframe.find('.pb_control_save[data-id='+pbid+']').removeClass('not_shown');
			// 	iframe.find('.pb_control_save[data-id='+pbid+']').addClass('shown');
			// 	$('#modal_faicon_editor').modal('hide');
			// });

			// function replaceIcon (el, content, oldicon) {
			// 	elclass = iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('class');
			// 	newclass = elclass.replace(oldicon, content);
			// 	iframe.find('.pageblock_body').find("[data-unique='"+el+"']").attr('class', newclass);
			// 	iframe.find('.pageblock_body').find("[data-unique='"+el+"']").removeAttr('data-unique');
			// 	iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").attr('class', newclass);
			// 	iframe.find('.pageblock_body_raw').find("[data-unique='"+el+"']").removeAttr('data-unique');
			// }

			// function findInObject(object, property, value) {
			// 	for (var i = 0; i < object.length; i += 1) {
			// 		if (object[i][property] === value) {
			// 			return i;
			// 		}
			// 	}
			// }
				












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
					      		'Your block has been deleted.',
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
			  		var pb_html_old = iframe.find('#pageblock_body_code_'+pb_id).html();
			  		var pb_html = pb_html_old.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
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
                    	var iframe_div = document.getElementById('pagebuilder_iframe');
                    	iframe_div.src = iframe_div.src;
                        //iframe.find('#pageblock_body_raw_'+pb_id).html(data.raw);
                        //var pb_html = iframe.find('#pageblock_body_raw_'+pb_id).html();
                        //var editor = ace.edit('ace_editor_'+pb_id); 
                        //editor.setValue(data.raw);
                        //iframe.find('#pageblock_body_'+pb_id).html(data.body);
                        //iframe.find('#pageblock_overlay_'+pb_id).removeClass('shown');
			  			//iframe.find('#pageblock_overlay_'+pb_id).addClass('not_shown');
			  			//iframe.find('#pageblock_body_'+pb_id).removeClass('not_shown');
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
                	var iframe_div = document.getElementById('pagebuilder_iframe');
                    	iframe_div.src = iframe_div.src;
       //              iframe.find('#pageblock_body_raw_'+pb_id).html(data.raw);
       //              var pb_html = iframe.find('#pageblock_body_raw_'+pb_id).html();
       //              iframe.find('#pageblock_body_'+pb_id).html(data.body);
       //              iframe.find('#pageblock_overlay_'+pb_id).removeClass('shown');
		  			// iframe.find('#pageblock_overlay_'+pb_id).addClass('not_shown');
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

			$( document ).find('.pb_add_block_top_button').each(function(){
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
		}



	});



		$( document ).ready(function() {

			

// LINE LINE LINE LINE LINE LINE LINE LINE LINE LINE //
			
			    
		});
	</script>
@endsection