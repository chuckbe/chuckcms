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

<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet" type="text/css">
<link href="https://cdn.chuck.be/chuckcms/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.chuck.be/chuckcms/css/dashboard.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.chuck.be/chuckcms/css/table.css" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('chuckbe/chuckcms/css/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('chuckbe/chuckcms/css/pages-icons.css') }}" rel="stylesheet" type="text/css" />
<style>
.dataTables_wrapper .row {
    width: 100%;
}
.dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate {
    margin-top: 25px !important;
}
.dataTables_wrapper .row > div {
    display: flex;
    justify-content: space-between;
    width: 100%;
    flex-direction: row-reverse;
}
.dataTables_wrapper .dataTables_paginate {
  float: right;
}
.dataTables_wrapper .dataTables_paginate ul > li.disabled a {
  opacity: .5;
}
.dataTables_wrapper .dataTables_paginate ul > li > a {
  padding: 5px 10px;
  color: #7a8994;
  opacity: .35;
  -webkit-transition: opacity 0.3s ease;
  transition: opacity 0.3s ease;
}
.dataTables_wrapper .dataTables_paginate ul > li > a:hover {
  opacity: .65;
}
.dataTables_wrapper .dataTables_paginate ul > li.next > a,
.dataTables_wrapper .dataTables_paginate ul > li.prev > a {
  opacity: 1;
}
.dataTables_wrapper .dataTables_paginate ul > li.disabled a {
  opacity: .35;
}
.dataTables_wrapper .dataTables_paginate ul > li.disabled a:hover {
  opacity: .35;
}
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
  margin-top: 25px !important;
}
.dataTables_paginate.paging_bootstrap.pagination {
  padding-top: 0;
  padding-right: 20px;
}
.dataTables_wrapper .dataTables_info {
  clear: none;
  font-size: 12px;
  padding: 0 33px;
  color: #7a8994;
}
.dataTables_wrapper .dataTables_paginate ul > li {
  display: inline-block;
  padding-left: 0;
  font-size: 11px;
}
.dataTables_wrapper .dataTables_paginate ul > li.active > a {
  font-weight: bold;
  color: #7a8994;
  opacity: 1;
}
/* Responsive Handlers : Tables */
@media (max-width: 991px) {
  .dataTables_paginate.paging_bootstrap.pagination {
    float: right;
  }
}
@media (max-width: 480px) {
  .dataTables_wrapper .dataTables_info,
  .dataTables_wrapper .dataTables_paginate {
    float: none;
    text-align: left;
    clear: both;
    display: block;
  }
}

</style>  
@yield('css')
</head>
<body class="light-version">

    @include('chuckcms::backend.includes.navigation')

    @yield('content')
    
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<script src="https://cdn.chuck.be/chuckcms/jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/popper.js@1.16.0/popper.min.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.chuck.be/chuckcms/js/dashboard.js" type="text/javascript"></script>
<script src="https://cdn.chuck.be/chuckcms/js/table.js" type="text/javascript"></script>

@yield('scripts')
</body>
</html>