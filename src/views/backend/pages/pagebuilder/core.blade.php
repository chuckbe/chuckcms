@extends($template->hintpath . '::templates.' . $template->slug . '.layouts.builder')

@section('title')
    {{ $page->title }}
@endsection

@section('meta')
<meta name="author" content="ChuckCMS" />
<meta name="description" content="Pagebuilder ChuckCMS">
@endsection

@section('css')
<style>
i{
	margin-right:0px!important;
}
.not_shown{
	display:none;
}
.shown{
	display:inherit;
}
.pb_control_save.shown{
	display:inline-block!important;
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
	z-index: 9999;
}

.pageblock_body_raw{
	display:none;
}
.pageblock_body_code{
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

	.pb_element_link_hover{
		-webkit-box-shadow: 0px 0px 0px 2px rgba(0,0,255,1)!important;
		-moz-box-shadow: 0px 0px 0px 2px rgba(0,0,255,1)!important;
		box-shadow: 0px 0px 0px 2px rgba(0,0,255,1)!important;
		cursor: pointer!important;
	}

	.pb_element_img_hover{
		-webkit-box-shadow: 0px 0px 0px 2px rgba(0,255,0,1)!important;
		-moz-box-shadow: 0px 0px 0px 2px rgba(0,255,0,1)!important;
		box-shadow: 0px 0px 0px 2px rgba(0,255,0,1)!important;
		cursor: pointer!important;
	}

	.pb_element_bg_hover{
		-webkit-box-shadow: 0px 0px 0px 2px rgba(0,255,255,1)!important;
		-moz-box-shadow: 0px 0px 0px 2px rgba(0,255,255,1)!important;
		box-shadow: 0px 0px 0px 2px rgba(0,255,255,1)!important;
		cursor: pointer!important;
	}

	.pb_element_icon_hover{
		-webkit-box-shadow: 0px 0px 0px 2px rgba(255,0,255,1)!important;
		-moz-box-shadow: 0px 0px 0px 2px rgba(255,0,255,1)!important;
		box-shadow: 0px 0px 0px 2px rgba(255,0,255,1)!important;
		cursor: pointer!important;
	}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('scripts')
	<script src="https://cdn.chuck.be/assets/plugins/ace/ace.js"></script>
@endsection

@section('content')
<div>
    <div>
        <a id="add_block_top" style="border:none;color:dodgerblue;">
            <div class="panel panel-default mb-none" style="background:#ececec;border:dashed dodgerblue 4px;margin-bottom:0px;">
                <div class="panel-body text-center">
					<h3 style="margin:20px 0!important;">PAGINA BLOCK TOEVOEGEN</h3>
                </div>
            </div>
        </a>
    </div>
</div>


<div class="pageblock_container" style="background:#FFF;">
	<div>
		@if($pageblocks !== null)
	        @foreach($pageblocks as $pageblock)
	            <div class="pageblock_body_container" id="pageblock-{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}" data-id="{{ $pageblock['id'] }}">
	            	<div class="pageblock_overlay not_shown" id="pageblock_overlay_{{ $pageblock['id'] }}"></div>
	            	<div id="pb_controls">
	            		@can('edit pagebuilder')
		            		<a href="" class="btn btn-sm btn-danger pb_control_delete" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-trash"></i>
		            		</a>
		            		<a href="" class="btn btn-sm btn-secondary pb_control_move_down" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-caret-down"></i>
		            		</a>
		            		<a href="" class="btn btn-sm btn-secondary pb_control_move_up" data-id="{{ $pageblock['id'] }}" data-order="{{ $pageblock['order'] }}">
		            			<i class="fa fa-caret-up"></i>
		            		</a>
		            	@endcan
		            	@can('code pagebuilder')
		            		<a href="" class="btn btn-sm btn-primary pb_control_edit" data-id="{{ $pageblock['id'] }}">
		            			<i class="fa fa-code"></i>
		            		</a>
		            		<a href="" class="btn btn-sm btn-success pb_control_save_code not_shown" data-id="{{ $pageblock['id'] }}">
		            			<i class="fa fa-check"></i>
		            		</a>
	            		@endcan
	            		@can('edit pagebuilder')
		            		<a href="" class="btn btn-sm btn-success pb_control_save not_shown" data-id="{{ $pageblock['id'] }}">
		            			<i class="fa fa-check"></i>
		            		</a>
	            		@endcan
	            	</div>{{-- 
	            	<div id="ace_editor_{{ $pageblock['id'] }}" class="ace_editor_height_null">
	            	</div> --}}
	            	<div class="pageblock_body" id="pageblock_body_{{ $pageblock['id'] }}" data-pbid="{{ $pageblock['id'] }}">{!! $pageblock['body'] !!}</div>
	            	<div class="pageblock_body_raw" id="pageblock_body_raw_{{ $pageblock['id'] }}" data-pbid="{{ $pageblock['id'] }}">{!! $pageblock['raw'] !!}</div>
	            	<div class="pageblock_body_code" id="pageblock_body_code_{{ $pageblock['id'] }}" data-pbid="{{ $pageblock['id'] }}">{{ htmlspecialchars_decode($pageblock['raw']) }}</div>
	            </div>
			@endforeach
	    @endif
	</div>
</div>    

<div>
    <div>
        <a id="add_block_bottom" style="border:none;color:dodgerblue;">
            <div class="panel panel-default" style="background:#ececec;border:dashed dodgerblue 4px;margin-bottom:0px;">
                <div class="panel-body text-center">
					<h3 style="margin:20px 0!important;">PAGINA BLOCK TOEVOEGEN</h3>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection