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
<meta content="Karel Brijs — Chuck | digital agency" name="author" />
@hasSection('meta')
@yield('meta')
@endif
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet" type="text/css">
<link href="https://cdn.chuck.be/chuckcms/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.chuck.be/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
<link href="https://cdn.chuck.be/chuckcms/css/dashboard.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.chuck.be/chuckcms/css/table.css" rel="stylesheet" type="text/css" />
{{-- <link href="https://cdn.chuck.be/chuckcms/css/Datatables.css" rel="stylesheet" type="text/css" /> --}}
<link href="{{ URL::to('chuckbe/chuckcms/css/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ URL::to('chuckbe/chuckcms/css/pages-icons.css') }}" rel="stylesheet" type="text/css" />  --}}
<link href="https://cdn.chuck.be/chuckcms/css/min-height.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
@yield('css')
<style>
.data-row .sessionurl .hide{
    opacity: 0;
    transition: 0.5s ease opacity;
}
.data-row .sessionurl:hover .hide{
    opacity: 1;
}
</style>
</head>
<body class="light-version">

@include('chuckcms::backend.includes.navigation')

@yield('content')

@include('chuckcms::backend.includes.footer')
    
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
<script src="https://kit.fontawesome.com/e23a04b30b.js" crossorigin="anonymous"></script>
<script src="https://cdn.chuck.be/chuckcms/jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/popper.js@1.16.0/popper.min.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.chuck.be/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="https://cdn.chuck.be/chuckcms/js/dashboard.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/js/table.js" type="text/javascript"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js" type="text/javascript"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
@yield('scripts')
</body>
</html>