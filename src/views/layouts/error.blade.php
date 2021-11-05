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
    <link href="https://cdn.chuck.be/assets/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="https://cdn.chuck.be/assets/pages/css/themes/light.css" rel="stylesheet" type="text/css" />
    @yield('css')
  </head>
  <body class="fixed-header error-page">
    <div class="d-flex justify-content-center full-height full-width align-items-center">
      <div class="error-container text-center">
        @yield('content')
      </div>
    </div>
    <div class="pull-bottom sm-pull-bottom full-width d-flex align-items-center justify-content-center">
      <div class="error-container">
        <div class="error-container-innner">
          <div class="p-b-30 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix d-flex-md-up row no-margin">
            <div class="col-md-2 no-padding d-flex align-items-center justify-content-center">
            </div>
            <div class="col-md-8 no-padding d-flex align-items-center justify-content-center">
              <p class="small no-margin flex-1">
                Powered by ChuckCMS © {{ date('Y')}} <br>
                All Rights Reserved
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE CONTAINER -->
    @include('chuckcms::backend.includes.search')
    <!-- BEGIN VENDOR JS -->
    <script src="https://cdn.chuck.be/assets/plugins/feather-icons/feather.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/tether/js/tether.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="https://cdn.chuck.be/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="https://cdn.chuck.be/assets/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/classie/classie.js" type="text/javascript"></script>
    <script src="https://cdn.chuck.be/assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="https://cdn.chuck.be/assets/pages/js/pages.min.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="https://cdn.chuck.be/assets/js/scripts.js" type="text/javascript"></script>
    @yield('scripts')
    <!-- END PAGE LEVEL JS -->
  </body>
</html>