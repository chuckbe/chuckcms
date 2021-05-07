@extends('chuckcms::backend.layouts.base')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
	Matomo
@endsection

@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.1.1/dist/svgMap.min.css" rel="stylesheet">
  <style>
    .daterangepicker {
      position: absolute;
      color: inherit;
      background-color: #fff;
      border-radius: 4px;
      border: 1px solid #ddd;
      width: 278px;
      max-width: none;
      padding: 0;
      margin-top: 7px;
      top: 100px;
      left: 20px;
      z-index: 3001;
      display: none;
      font-family: arial;
      font-size: 15px;
      line-height: 1em;
    }
    .daterangepicker:before, .daterangepicker:after {
      position: absolute;
      display: inline-block;
      border-bottom-color: rgba(0, 0, 0, 0.2);
      content: '';
    }

    .daterangepicker:before {
      top: -7px;
      border-right: 7px solid transparent;
      border-left: 7px solid transparent;
      border-bottom: 7px solid #ccc;
    }

    .daterangepicker:after {
      top: -6px;
      border-right: 6px solid transparent;
      border-bottom: 6px solid #fff;
      border-left: 6px solid transparent;
    }

    .daterangepicker.opensleft:before {
      right: 9px;
    }

    .daterangepicker.opensleft:after {
      right: 10px;
    }

    .daterangepicker.openscenter:before {
      left: 0;
      right: 0;
      width: 0;
      margin-left: auto;
      margin-right: auto;
    }

    .daterangepicker.openscenter:after {
      left: 0;
      right: 0;
      width: 0;
      margin-left: auto;
      margin-right: auto;
    }

    .daterangepicker.opensright:before {
      left: 9px;
    }

    .daterangepicker.opensright:after {
      left: 10px;
    }

    .daterangepicker.drop-up {
      margin-top: -7px;
    }

    .daterangepicker.drop-up:before {
      top: initial;
      bottom: -7px;
      border-bottom: initial;
      border-top: 7px solid #ccc;
    }

    .daterangepicker.drop-up:after {
      top: initial;
      bottom: -6px;
      border-bottom: initial;
      border-top: 6px solid #fff;
    }

    .daterangepicker.single .daterangepicker .ranges, .daterangepicker.single .drp-calendar {
      float: none;
    }

    .daterangepicker.single .drp-selected {
      display: none;
    }

    .daterangepicker.show-calendar .drp-calendar {
      display: block;
    }

    .daterangepicker.show-calendar .drp-buttons {
      display: block;
    }

    .daterangepicker.auto-apply .drp-buttons {
      display: none;
    }

    .daterangepicker .drp-calendar {
      display: none;
      max-width: 270px;
    }

    .daterangepicker .drp-calendar.left {
      padding: 8px 0 8px 8px;
    }

    .daterangepicker .drp-calendar.right {
      padding: 8px;
    }

    .daterangepicker .drp-calendar.single .calendar-table {
      border: none;
    }

    .daterangepicker .calendar-table .next span, .daterangepicker .calendar-table .prev span {
      color: #fff;
      border: solid black;
      border-width: 0 2px 2px 0;
      border-radius: 0;
      display: inline-block;
      padding: 3px;
    }

    .daterangepicker .calendar-table .next span {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }

    .daterangepicker .calendar-table .prev span {
      transform: rotate(135deg);
      -webkit-transform: rotate(135deg);
    }

    .daterangepicker .calendar-table th, .daterangepicker .calendar-table td {
      white-space: nowrap;
      text-align: center;
      vertical-align: middle;
      min-width: 32px;
      width: 32px;
      height: 24px;
      line-height: 24px;
      font-size: 12px;
      border-radius: 4px;
      border: 1px solid transparent;
      white-space: nowrap;
      cursor: pointer;
    }

    .daterangepicker .calendar-table {
      border: 1px solid #fff;
      border-radius: 4px;
      background-color: #fff;
    }

    .daterangepicker .calendar-table table {
      width: 100%;
      margin: 0;
      border-spacing: 0;
      border-collapse: collapse;
    }

    .daterangepicker td.available:hover, .daterangepicker th.available:hover {
      background-color: #eee;
      border-color: transparent;
      color: inherit;
    }

    .daterangepicker td.week, .daterangepicker th.week {
      font-size: 80%;
      color: #ccc;
    }

    .daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date {
      background-color: #fff;
      border-color: transparent;
      color: #999;
    }

    .daterangepicker td.in-range {
      background-color: #ebf4f8;
      border-color: transparent;
      color: #000;
      border-radius: 0;
    }

    .daterangepicker td.start-date {
      border-radius: 4px 0 0 4px;
    }

    .daterangepicker td.end-date {
      border-radius: 0 4px 4px 0;
    }

    .daterangepicker td.start-date.end-date {
      border-radius: 4px;
    }

    .daterangepicker td.active, .daterangepicker td.active:hover {
      background-color: #357ebd;
      border-color: transparent;
      color: #fff;
    }

    .daterangepicker th.month {
      width: auto;
    }

    .daterangepicker td.disabled, .daterangepicker option.disabled {
      color: #999;
      cursor: not-allowed;
      text-decoration: line-through;
    }

    .daterangepicker select.monthselect, .daterangepicker select.yearselect {
      font-size: 12px;
      padding: 1px;
      height: auto;
      margin: 0;
      cursor: default;
    }

    .daterangepicker select.monthselect {
      margin-right: 2%;
      width: 56%;
    }

    .daterangepicker select.yearselect {
      width: 40%;
    }

    .daterangepicker select.hourselect, .daterangepicker select.minuteselect, .daterangepicker select.secondselect, .daterangepicker select.ampmselect {
      width: 50px;
      margin: 0 auto;
      background: #eee;
      border: 1px solid #eee;
      padding: 2px;
      outline: 0;
      font-size: 12px;
    }

    .daterangepicker .calendar-time {
      text-align: center;
      margin: 4px auto 0 auto;
      line-height: 30px;
      position: relative;
    }

    .daterangepicker .calendar-time select.disabled {
      color: #ccc;
      cursor: not-allowed;
    }

    .daterangepicker .drp-buttons {
      clear: both;
      text-align: right;
      padding: 8px;
      border-top: 1px solid #ddd;
      display: none;
      line-height: 12px;
      vertical-align: middle;
    }

    .daterangepicker .drp-selected {
      display: inline-block;
      font-size: 12px;
      padding-right: 8px;
    }

    .daterangepicker .drp-buttons .btn {
      margin-left: 8px;
      font-size: 12px;
      font-weight: bold;
      padding: 4px 8px;
    }

    .daterangepicker.show-ranges.single.rtl .drp-calendar.left {
      border-right: 1px solid #ddd;
    }

    .daterangepicker.show-ranges.single.ltr .drp-calendar.left {
      border-left: 1px solid #ddd;
    }

    .daterangepicker.show-ranges.rtl .drp-calendar.right {
      border-right: 1px solid #ddd;
    }

    .daterangepicker.show-ranges.ltr .drp-calendar.left {
      border-left: 1px solid #ddd;
    }

    .daterangepicker .ranges {
      float: none;
      text-align: left;
      margin: 0;
    }

    .daterangepicker.show-calendar .ranges {
      margin-top: 8px;
    }

    .daterangepicker .ranges ul {
      list-style: none;
      margin: 0 auto;
      padding: 0;
      width: 100%;
    }

    .daterangepicker .ranges li {
      font-size: 12px;
      padding: 8px 12px;
      cursor: pointer;
    }

    .daterangepicker .ranges li:hover {
      background-color: #eee;
    }

    .daterangepicker .ranges li.active {
      background-color: #08c;
      color: #fff;
    }
    .modal#settingsmodal{
      background-color: rgba(0,0,0,0.6);
    }

    /*  Larger Screen Styling */
    @media (min-width: 564px) {
      .daterangepicker {
        width: auto;
      }

      .daterangepicker .ranges ul {
        width: 140px;
      }

      .daterangepicker.single .ranges ul {
        width: 100%;
      }

      .daterangepicker.single .drp-calendar.left {
        clear: none;
      }

      .daterangepicker.single .ranges, .daterangepicker.single .drp-calendar {
        float: left;
      }

      .daterangepicker {
        direction: ltr;
        text-align: left;
      }

      .daterangepicker .drp-calendar.left {
        clear: left;
        margin-right: 0;
      }

      .daterangepicker .drp-calendar.left .calendar-table {
        border-right: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
      }

      .daterangepicker .drp-calendar.right {
        margin-left: 0;
      }

      .daterangepicker .drp-calendar.right .calendar-table {
        border-left: none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
      }

      .daterangepicker .drp-calendar.left .calendar-table {
        padding-right: 8px;
      }

      .daterangepicker .ranges, .daterangepicker .drp-calendar {
        float: left;
      }
    }

    @media (min-width: 730px) {
      .daterangepicker .ranges {
        width: auto;
      }

      .daterangepicker .ranges {
        float: left;
      }

      .daterangepicker.rtl .ranges {
        float: right;
      }

      .daterangepicker .drp-calendar.left {
        clear: none !important;
      }
    }
  </style>
@endsection

@section('scripts')
  <script src="{{ URL::to('/vendor/laravel-filemanager/js/lfm.js') }}"></script>
	<script>
		$( document ).ready(function() { 
			
      init();

      function init () {
        //init media manager inputs 
        var domain = "{{ URL::to('dashboard/media')}}";
        $('#lfmFavi').filemanager('image', {prefix: domain});
        $('#lfmLogo').filemanager('image', {prefix: domain});
      }

      $(".selectjs").select2();
		});
	</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@3.6.1/dist/svg-pan-zoom.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.1.1/dist/svgMap.min.js"></script>
  <script src="{{asset('chuckbe/chuckcms/vendor/svg-map/countriesEN.js')}}"></script>
  @if (session('notification'))
      @include('chuckcms::backend.includes.notification')
  @endif
  <script src="https://cdnjs.cloudflare.com/ajax/libs/kartograph-js/0.8.7/kartograph.min.js" integrity="sha512-L4PJPMY6KTM9aMBxyrxBEQZGcfOEctt5XzZ1VaRT/rBI/7uJbThQejdw8r/JaoaPWE5/URD5Je2UESAu/uV5Yw==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.js" integrity="sha512-2h6nRNAf9ejT/sqEs1Pg7mmafcJCla+tVGo1zDQDH1U+abXb0CxzjGIJEFpzHSfG27bGHM4K+UpDXwaF0gzCHw==" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  @include('chuckcms::backend.matomo.script')
  @if(isset($matomoSiteId) || isset($matomoAuthToken))
    @if($matomoSiteId == null || $matomoAuthToken == null)
      <script>
        $(function() {
          window.location.replace("/dashboard/settings?integration=active");
          // $('#settingsmodal').modal({
          //   backdrop: 'static',
          //   keyboard: false
          // });
        });
      </script>
    @endif
  @endif
@endsection

@section('content')
@include('chuckcms::backend.includes.matomo')
@endsection