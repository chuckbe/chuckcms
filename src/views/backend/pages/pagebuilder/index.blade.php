@extends('chuckcms::backend.layouts.pagebuilder')

@section('content')
<iframe src="{{ route('dashboard.page.raw', ['page_id' => $page->id]).'?lang='.app()->getLocale() }}" frameborder="0" style="width:90%;height:80vh;margin-left:5%;" id="pagebuilder_iframe"></iframe>

@include('chuckcms::backend.pages.pagebuilder.includes._modal_add_block_top')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_add_block_bottom')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_edit_title')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_edit_text')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_edit_code')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_edit_image')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_edit_link')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_edit_background')
@include('chuckcms::backend.pages.pagebuilder.includes._modal_edit_icons')
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
<script src="{{ URL::to('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
$('#pagebuilder_iframe').on('load', function(){
  var iframe = $('#pagebuilder_iframe').contents();
	var token = '{{ Session::token() }}';
  init();
		

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
			  		var pb_html_old = iframe.find('#pageblock_body_code_'+pb_id).text();
			  		var pb_html = pb_html_old.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
			  		console.log('the pb html : ', pb_html);
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

			// $( document ).find('.pb_add_block_top_button').each(function(){
			// 	var pb_name = $(this).attr("data-name");
			// 	var pb_location = $(this).attr("data-location");
			//   	$(this).click(function (event) {
			//   		event.preventDefault();
			//   		$.ajax({
   //                      method: 'POST',
   //                      url: "{{ route('api.pageblock.add_block_top') }}",
   //                      data: { 
   //                      	name: pb_name,
   //                      	location: pb_location, 
   //                      	page_id: "{{ $page->id }}", 
   //                      	_token: token
   //                      }
   //                  })
   //                  .done(function (data) {
   //                  	document.location = document.location.href;
   //                  });
			//     });
			// });

      // $( document ).find('.pb_add_block_bottom_button').each(function(){
      //   var pb_name = $(this).attr("data-name");
      //   var pb_location = $(this).attr("data-location");
      //     $(this).click(function (event) {
      //       event.preventDefault();
      //       $.ajax({
      //           method: 'POST',
      //           url: "{{ route('api.pageblock.add_block_bottom') }}",
      //           data: { 
      //             name: pb_name,
      //             location: pb_location, 
      //             page_id: "{{ $page->id }}", 
      //             _token: token
      //           }
      //       })
      //       .done(function (data) {
      //         document.location = document.location.href;
      //       });
      //     });
      // });
	}
});












$( document ).ready(function() {
  var token = '{{ Session::token() }}';

  $('body').on('click', '.pb_add_block_top_button', function(event) {
    event.preventDefault();
    var pb_name = $(this).attr("data-name");
    var pb_location = $(this).attr("data-location");
    $.ajax({
        method: 'POST',
        url: "{{ route('api.pageblock.add_block_top').'?lang='.app()->getLocale() }}",
        data: { 
          name: pb_name,
          location: pb_location, 
          page_id: "{{ $page->id }}", 
          _token: token
        }
    })
    .done(function (data) {
      if(data == 'success') {
        document.location = document.location.href;
      }
      return;
    });
  });

  $('body').on('click', '.pb_add_block_bottom_button', function(event) {
    event.preventDefault();
    var pb_name = $(this).attr("data-name");
    var pb_location = $(this).attr("data-location");
    $.ajax({
        method: 'POST',
        url: "{{ route('api.pageblock.add_block_bottom').'?lang='.app()->getLocale() }}",
        data: { 
          name: pb_name,
          location: pb_location, 
          page_id: "{{ $page->id }}", 
          _token: token
        }
    })
    .done(function (data) {
      document.location = document.location.href;
      return;
    });
  });
});
</script>
@endsection