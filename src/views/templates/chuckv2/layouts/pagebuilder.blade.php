<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    @yield('meta')
    <!-- Document title -->
    <title>@yield('title')</title>
    <!-- Stylesheets & Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,800,700,600|Montserrat:400,500,600,700|Raleway:100,300,600,700,800" rel="stylesheet" type="text/css" />
    <link href="{{ asset('chuckbe/chuckcms/chuckv2/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('chuckbe/chuckcms/chuckv2/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('chuckbe/chuckcms/chuckv2/css/responsive.css') }}" rel="stylesheet"> 
    @yield('css')
</head>

<body>

    <!-- Wrapper -->
    <div id="wrapper">
        @yield('content')
    </div>
    <!-- end: Wrapper -->

    <!-- Go to top button -->
    <a id="goToTop"><i class="fa fa-angle-up top-icon"></i><i class="fa fa-angle-up"></i></a>
    <!--Plugins-->
    <script src="{{ asset('chuckbe/chuckcms/chuckv2/js/jquery.js') }}"></script>
    <script src="{{ asset('chuckbe/chuckcms/chuckv2/js/plugins.js') }}"></script>

    <!--Template functions-->
    <script src="{{ asset('chuckbe/chuckcms/chuckv2/js/functions.js') }}"></script>
    @yield('scripts')
</body>

</html>

