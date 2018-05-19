@extends('chuckcms::templates.' . $template->slug . '.layouts.base')

@section('title')
    {{ $page->title }}
@endsection

@section('meta')

@endsection

@section('css')

@endsection

@section('scripts')

@endsection

@section('content')
	<h1>{{ $page->title }}</h1>
	<hr>
	<br>
    @if($pageblocks !== null)
        @foreach($pageblocks as $pageblock)
            {!! $pageblock['body'] !!}
        @endforeach
    @endif
@endsection