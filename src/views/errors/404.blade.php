@extends('chuckcms::layouts.error')

@section('title')
    Whoops!
@endsection

@section('meta')

@endsection

@section('css')

@endsection

@section('scripts')

@endsection

@section('content')
	<h1 class="error-number">404</h1>
	<h2 class="semi-bold">{{ $exception->getMessage() }}</h2>
	<p class="p-b-10">Something went wrong. <a href="#">Report this?</a></p>
@endsection