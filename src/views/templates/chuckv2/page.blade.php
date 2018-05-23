@extends('chuckcms::templates.' . $template->slug . '.layouts.base')

@section('title')
    {{ $page->title }}
@endsection

@section('meta')
<meta name="author" content="ChuckCMS" />
<meta name="description" content="Template Branding">
@endsection

@section('css')

@endsection

@section('scripts')

@endsection

@section('content')
    @if($pageblocks !== null)
        @foreach($pageblocks as $pageblock)
            {!! $pageblock['body'] !!}
        @endforeach
    @endif
@endsection