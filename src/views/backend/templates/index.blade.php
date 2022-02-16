@extends('chuckcms::backend.layouts.base')

@section('content')
<div class="container p-3">
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active" aria-current="page">Templates</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row bg-light shadow-sm rounded p-3 mb-3 mx-1">
        <div class="col-sm-12 my-3">
            <div class="row">
            	<div class="col-sm-6"><small>Naam</small></div>
            	<div class="col-sm-3"><small>Auteur</small></div>
            	<div class="col-sm-3"><small>Type</small></div>
            	<div class="col-sm-12"><hr></div>
            </div>
            @foreach($templates as $tmp)
            <div class="row">
            	<div class="col-sm-6">
            		@if($tmp->active == 1)
            		<i class="fa fa-circle" style="color:chartreuse;"></i>
                	@else
            		<i class="fa fa-circle" style="color:red;"></i>
                	@endif 
                	{{ $tmp->name }} (v{{ $tmp->version }})
            	</div>
            	<div class="col-sm-3">{{ $tmp->author }}</div>
            	<div class="col-sm-3">
            		{{ $tmp->type }}
            		@can('edit templates')
		    		<a href="{{ route('dashboard.templates.edit', ['slug' => $tmp->slug]) }}" class="btn btn-sm btn-outline-secondary rounded float-right">
		    			<i class="fa fa-pen"></i> edit
		    		</a>
		    		@endcan
            	</div>
            	<div class="col-sm-12"><hr></div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('css')
	
@endsection

@section('scripts')

@endsection










