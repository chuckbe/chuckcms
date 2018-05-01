@extends('chuckcms::templates.' . $template->slug . '.layouts.boarder')

@section('css')
    {{-- <link rel="stylesheet" href="{{ URL::to('css/jqtree.css') }}"> --}}
@endsection

@section('scripts')
    {!! ChuckMenu::scripts() !!}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Navigatie</div>
                
                <div class="panel-body">
                    {!! ChuckMenu::render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection