@extends('chuckcms::backend.layouts.base')

@section('css')
    {{-- <link rel="stylesheet" href="{{ URL::to('css/jqtree.css') }}"> --}}
@endsection

@section('scripts')
    {!! ChuckMenu::scripts() !!}
@endsection

@section('content')
<div class="container p-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Navigatie</div>
                
                <div class="panel-body">
                    {!! ChuckMenu::render($pages) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection