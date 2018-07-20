<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    @yield('meta')
    <!-- Document title -->
    <title>@yield('title')</title>
    <!-- Stylesheets & Fonts -->
    @if($template->fonts)
    <link href="//fonts.googleapis.com/css?family={{ $template->fonts['raw'] }}" rel="stylesheet" type="text/css" />
    @endif
    @if($template->css)
    @foreach($template->css as $cssname => $cssraw)
    @if($cssraw['asset'] == true)
    <link href="{{ asset($cssraw['href']) }}" rel="stylesheet">
    @else
    <link href="{{ $cssraw['href'] }}" rel="stylesheet">
    @endif
    @endforeach
    @endif
    @yield('css')
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>

<body style="overflow-x:hidden;">
    <nav class="navbar navbar-default navbar-static-top" style="margin-bottom:0px;">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" alt="logo" class="brand" data-src="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" data-src-retina="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" height="18">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('dashboard.pages') }}"><i class="fa fa-caret-left"></i> Terug</a></li>
                    <li><a href="" onclick="event.preventDefault()">Pagebuilder: {{ $page->title }}</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    
                </ul>
            </div>
        </div>
    </nav>
    <!-- Wrapper -->
    <div id="wrapper">
        @yield('content')
    </div>
    <!-- end: Wrapper -->

    @if($template->js)
    @foreach($template->js as $jsname => $jsraw)
        @if($cssraw['asset'] == true)
            <script src="{{ asset($jsraw['href']) }}"></script>
        @else
            <script src="{{ $jsraw['href'] }}"></script>
        @endif
    @endforeach
    @endif
    @yield('scripts')
</body>

</html>

