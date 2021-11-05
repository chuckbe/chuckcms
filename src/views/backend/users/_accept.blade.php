<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>ChuckCMS | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{ URL::to('chuckbe/chuckcms/pages/ico/60.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ URL::to('chuckbe/chuckcms/pages/ico/76.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ URL::to('chuckbe/chuckcms/pages/ico/120.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ URL::to('chuckbe/chuckcms/pages/ico/152.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ URL::to('chuckbe/chuckcms/favicon.ico') }}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{ asset('chuckbe/chuckcms/assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('chuckbe/chuckcms/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('chuckbe/chuckcms/assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('chuckbe/chuckcms/assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{ asset('chuckbe/chuckcms/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{ asset('chuckbe/chuckcms/assets/plugins/switchery/css/switchery.min.css') }}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{ asset('chuckbe/chuckcms/pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{ asset('chuckbe/chuckcms/pages/css/themes/light.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
    }
    </script>
  </head>
  <body class="fixed-header menu-pin">
    <div class="login-wrapper ">
      <!-- START Login Background Pic Wrapper-->
      <div class="bg-pic">
        <!-- START Background Pic-->
        <img src="{{ URL::to('chuckbe/chuckcms/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg') }}" data-src="{{ URL::to('chuckbe/chuckcms/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg') }}" data-src-retina="{{ URL::to('chuckbe/chuckcms/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg') }}" alt="" class="lazy">
        <!-- END Background Pic-->
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          <h2 class="semi-bold text-white">
                    ChuckCMS makes it easy to focus on what matters the most</h2>
          <p class="small">
            images Displayed are solely for representation purposes only, All work copyright of respective owner, otherwise © 2014-2018 Chuck.
          </p>
        </div>
        <!-- END Background Caption-->
      </div>
      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <img src="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" alt="logo" data-src="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" data-src-retina="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" height="36">
          <p class="p-t-35">Maak een wachtwoord om je account te activeren</p>
          <p> Je wachtwoord moet aan het volgende voldoen: <br>
            <ul>
              <li>Minimum 8 tekens</li>
              <li>Kleine letters</li>
              <li>Hoofdletters</li>
              <li>Speciale tekens</li>
            </ul>
          </p>
          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" role="form" method="POST" action="{{ route('activate.user') }}">
            
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-group-default">
              <label>Wachtwoord</label>
              <div class="controls">
                <input id="password" type="password" class="form-control" minlength="8" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('password_again') ? ' has-error' : '' }} form-group-default">
              <label>Bevestig Wachtwoord</label>
              <div class="controls">
                <input id="password" type="password" class="form-control" minlength="8" name="password_again" equalTo="#password" required>
                    @if ($errors->has('password_again'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_again') }}</strong>
                        </span>
                    @endif
              </div>
            </div>
            <!-- END Form Control-->
            <input type="hidden" name="_user_id" value="{{ $user->id }}">
            <input type="hidden" name="_user_token" value="{{ $token }}">
            <button class="btn btn-primary btn-cons m-t-10" type="submit">Bevestigen</button>
          </form>
          <!--END Login Form-->
          <div class="pull-bottom sm-pull-bottom">
            <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
              <div class="col-sm-3 col-md-2 no-padding">
                <img alt="" class="m-t-5" data-src="{{ URL::to('chuckbe/chuckcms/assets/img/demo/pages_icon.png') }}" data-src-retina="{{ URL::to('chuckbe/chuckcms/assets/img/demo/pages_icon_2x.png') }}" height="60" src="{{ URL::to('chuckbe/chuckcms/assets/img/demo/pages_icon.png') }}" width="60">
              </div>
              <div class="col-sm-9 no-padding m-t-10">
                <p>
                    <small>
                        ChuckCMS | All rights reserved. © {{ date('Y') }}
                    </small>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>
    <!-- BEGIN VENDOR JS -->
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/tether/js/tether.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery/jquery-easy.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery-ios-list/jquery.ioslist.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery-actual/jquery.actual.min.js') }}"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('chuckbe/chuckcms/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('chuckbe/chuckcms/assets/plugins/classie/classie.js') }}"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/switchery/js/switchery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('chuckbe/chuckcms/assets/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <script src="{{ asset('chuckbe/chuckcms/pages/js/pages.min.js') }}"></script>
    <script>
    $(function()
    {
      $('#form-login').validate()
    })
    </script>
  </body>
</html>
