<meta http-equiv="x-ua-compatible" content="ie=edge">
@php 
$lang = \LaravelLocalization::getCurrentLocale();
$meta = $page->meta[$lang];
@endphp
@if( array_key_exists('title', $meta) )
<meta name="title" content="{{ $meta['title'] }}">
@endif
@if(array_key_exists('description', $meta))
<meta name="description" content="{{ $meta['description'] }}">
@endif
@if(array_key_exists('keywords', $meta))
<meta name="keywords" content="{{ $meta['keywords'] }}">
@endif

@if(array_key_exists('robots', $meta))
<meta name="robots" content="{{ $meta['robots'] }}">
@endif
@if(array_key_exists('googlebots', $meta))
<meta name="googlebots" content="{{ $meta['googlebots'] }}">
@endif
<meta name="google" content="notranslate">
@if( ChuckSite::getSetting('integration.g-site-verification') !== null )
<meta name="google-site-verification" content="{{ ChuckSite::getSetting('integration.g-site-verification') }}">
@endif

<meta name="generator" content="ChuckCMS">

@if($page->isHp == 1)
<link rel="canonical" href="{{ ChuckSite::getSetting('domain') }}">
<meta property="og:url" content="{{ ChuckSite::getSetting('domain') }}">
<meta name="twitter:url" content="{{ ChuckSite::getSetting('domain') }}">
@else
<link rel="canonical" href="{{ ChuckSite::getSetting('domain') . '/' . $page->slug }}">
<meta property="og:url" content="{{ ChuckSite::getSetting('domain') . '/' . $page->slug }}">
<meta name="twitter:url" content="{{ ChuckSite::getSetting('domain') . '/' . $page->slug }}">
@endif

@if(array_key_exists('og-type', $meta))
<meta name="og:type" content="{{ $meta['og-type'] }}">
@endif
@if(array_key_exists('og:type', $meta))
<meta name="og:type" content="{{ $meta['og:type'] }}">
@endif

@if(array_key_exists('og-title', $meta))
<meta name="og:title" content="{{ $meta['og-title'] }}">
<meta name="twitter:title" content="{{ $meta['og-title'] }}">
<meta itemprop="name" content="{{ $meta['og-title'] }}">
@endif
@if(array_key_exists('og:title', $meta))
<meta name="og:title" content="{{ $meta['og:title'] }}">
<meta name="twitter:title" content="{{ $meta['og:title'] }}">
<meta itemprop="name" content="{{ $meta['og:title'] }}">
@endif

@if(array_key_exists('og-image', $meta))
<meta name="og:image" content="{{ $meta['og-image'] }}">
<meta name="twitter:image" content="{{ $meta['og-image'] }}">
<meta itemprop="image" content="{{ $meta['og-image'] }}">
@endif
@if(array_key_exists('og:image', $meta))
<meta name="og:image" content="{{ asset($meta['og:image']) }}">
<meta name="twitter:image" content="{{ asset($meta['og:image']) }}">
<meta itemprop="image" content="{{ asset($meta['og:image']) }}">
@endif

@if(array_key_exists('og-description', $meta))
<meta name="og:description" content="{{ $meta['og-description'] }}">
<meta name="twitter:description" content="{{ $meta['og-description'] }}">
<meta itemprop="description" content="{{ $meta['og-description'] }}">
@endif
@if(array_key_exists('og:description', $meta))
<meta name="og:description" content="{{ $meta['og:description'] }}">
<meta name="twitter:description" content="{{ $meta['og:description'] }}">
<meta itemprop="description" content="{{ $meta['og:description'] }}">
@endif

@if(ChuckSite::getSite('name') !== null)
<meta property="og:site_name" content="{{ ChuckSite::getSite('name') }}">
@endif
<meta property="og:locale" content="{{ $lang }}">