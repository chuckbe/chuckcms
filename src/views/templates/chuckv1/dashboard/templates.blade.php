@extends('chuckcms::templates.' . $template->slug . '.layouts.boarder')

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="breadcrumb-item active"><a href="{{ route('dashboard.settings') }}">Instellingen</a></li>
	</ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
		<div class="col-sm-8">
			<div class="col-sm-12">
				<div class="panel">
					<a href="" class="">
	    				<div class="panel-heading text-center">
	    					<span>voeg een template toe</span>
	    				</div>
					</a>
				</div>
			</div>
		</div>
        <div class="col-sm-8">
        	@foreach($all_templates as $tmp)
	        	<div class="col-sm-12">
		            <div class="panel panel-default">
		                <div class="panel-heading">
		                	@if($tmp->active == 1)
		                		<i class="fa fa-circle" style="color:chartreuse;"></i>
		                	@else
		                		<i class="fa fa-circle" style="color:red;"></i>
		                	@endif 
		                	{{ $tmp->name }} (v{{ $tmp->version }})

		                	<span class="pull-right">
		                		{{ $tmp->author }} 
		                		<a href=""><i class="fa fa-cog"></i></a>
		                	</span>
		                </div>
		            </div>
		        </div>
			@endforeach

        </div>
    </div>
</div>
@endsection