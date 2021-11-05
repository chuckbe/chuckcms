<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="https://cdn.chuck.be/assets/pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://cdn.chuck.be/assets/pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://cdn.chuck.be/assets/pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://cdn.chuck.be/assets/pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="{{ URL::to('chuckbe/chuckcms/favicon.ico') }}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link href="https://cdn.chuck.be/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.chuck.be/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('chuckbe/chuckcms/css/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.chuck.be/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="https://cdn.chuck.be/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="https://cdn.chuck.be/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="https://cdn.chuck.be/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen" />

    <link href="{{ URL::to('chuckbe/chuckcms/css/pages-icons.css') }}" rel="stylesheet" type="text/css" />
    
    @yield('css')
    <link class="main-stylesheet" href="https://cdn.chuck.be/assets/pages/css/themes/light.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="fixed-header menu-pin">
    @include('chuckcms::backend.includes.sidebar')
    <!-- START PAGE-CONTAINER -->
    <div class="page-container ">
      @include('chuckcms::backend.includes.top')
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
          <!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                <!-- START BREADCRUMB -->
                @yield('breadcrumbs')
                <!-- END BREADCRUMB -->
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class=" container-fluid   container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            @yield('content')
            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class=" container-fluid  container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
              <span class="hint-text">Copyright &copy; 2017 - {{ date('Y') }} </span>
              <span class="font-montserrat">Chuck</span>.
              <span class="hint-text">All rights reserved. </span>
              {{-- <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> <span class="muted">|</span> <a href="#" class="m-l-10">Privacy Policy</a></span> --}}
            </p>
            <p class="small no-margin pull-right sm-pull-reset">
              Hand-crafted <span class="hint-text">&amp; made with love</span>
            </p>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    {{-- @include('chuckcms::backend.includes.quickview') --}}
    <!-- include('chuckcms::backend.includes.search') -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <!-- BEGIN VENDOR JS -->
    <script src="https://cdn.chuck.be/assets/plugins/feather-icons/feather.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/tether/js/tether.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script type="text/javascript" src="https://cdn.chuck.be/assets/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript" src="https://cdn.chuck.be/assets/plugins/classie/classie.js"></script>
    <script src="https://cdn.chuck.be/assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="https://cdn.chuck.be/assets/pages/js/pages.min.js"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="https://cdn.chuck.be/assets/js/scripts.js" type="text/javascript"></script>
    @yield('scripts')
    <!-- END PAGE LEVEL JS -->
  </body>
</html>