<!doctype html>
<title>{{ $page->title }}</title>
@foreach ($pageblocks as $pageblock)
{!! $pageblock['body'] !!}
@endforeach
