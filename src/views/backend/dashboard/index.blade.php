@extends('chuckcms::backend.layouts.base')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
	Dashboard
@endsection
@section('css')
  @if(ChuckSite::getSetting('integrations.matomo-site-id') !== null && ChuckSite::getSetting('integrations.matomo-auth-key') !== null)
    <style>

      /* pagination */
      .easyPaginateNav{
        display: inline-block;
      }
      .easyPaginateNav a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
      }
      .easyPaginateNav a.current {
        background-color: #007bff;
        color: white;
      }
      .easyPaginateNav a:hover:not(.current) {background-color: #ddd;}
      .easyPaginateNav {
        display: flex;
        justify-content: flex-end;
      }

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


      .card {
        padding: 15px 0;
        font-size: 13px;
        text-align: left;
      }
      a.visitor-log-visitor-profile-link {
        z-index: 2;
        position: absolute;
        right: 15px;
        top: 15px;
        font-style: italic;
        font-size: 13px;
        background-color: inherit !important;
        cursor: pointer;
      }
      a.visitor-log-visitor-profile-link span,
      a.visitor-log-visitor-profile-link i {
        pointer-events: none;
      }
      .visitor-log-datetime {
        display: block;
      }
      .visitorReferrer {
        clear: both;
        padding-top: 1em;
      }
      .visitorReferrer * {
        vertical-align: middle;
      }
      .visitorLogIcons {
        position: relative;
        display: block;
      }
      .own-visitor-column .visitorLogIcons .visitorDetails {
          margin-top: 0;
      }
      .visitorLogIconWithDetails > img {
        margin: auto 5px -2px 0;
        height: 16px;
      }
      .visitorLogIcons > span > span > img {
        margin: auto 5px auto 0;
      }
      .visitorLogIconWithDetails .details {
        display: none !important;
        position: absolute;
        background: #000;
        color: white;
        text-align: center;
        padding: 5px;
        display: block;
        border-radius: 2px;
        left:10px;
        top: 30px;
        font-size: 8px;
        transition: 0.5s ease display;
      }
      .visitorLogIconWithDetails:hover .details{
        display: block !important;
      } 
      ul:not(.browser-default)>li {
        list-style-type: none;
      }
      .visitorLogIconWithDetails.flag {
        display: none;
      }
      .visitorLogIconWithDetails.flag > img {
        border: 1px solid lightgray;
      }
      .visitorLogReplaySession {
        margin-top: 10px;
        padding-bottom: 5px;
        display: block;
        width: auto !important;
      }
      .visitorLogReplaySession:hover {
          color: #43a047 !important;
          text-decoration: none;
      }
      .visitor-log-page-list {
        position: relative;
        margin-top: 7px;
      }
      ol.visitorLog {
        list-style-type: none;
        margin-left: 8px;
        padding-left: 8px;
      }
      ol.actionList > li:not(.pageviewActions){
        margin-bottom: 10px;
        line-height: 20px;
        position: relative;
        min-height: 30px;
      }
      ol.actionList > li:not(.pageviewActions):before {
        vertical-align: top;
        background-color: #424242;
        border: 5px solid #424242;
        border-radius: 50%;
        line-height: 0;
        font-size: 0;
        content: " ";
        top: 10px;
        position: relative;
        box-shadow: 0 0 0 7px #fff;
        left: -14px;
        z-index: 2;
      }
      ol.actionList > li:not(.pageviewActions):after {
        content: " ";
        border-left: 2px solid #d2d2d2;
        position: absolute;
        left: -10px;
        height: calc(100% - 20px);
        margin-top: 20px;
        z-index: 1;
      }
      ol.actionList > li:not(.pageviewActions):last-of-type:after {
        border-left: none;
      }
      .actionList > li > div {
        display: inline-block;
        width: 90%;
      }
      .actionList > li > div {
        width: 95%;
      }
      .actionList > li > div > * {
        vertical-align: top;
      }
      .truncated-text-line {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
        max-width: 90%;
        overflow: -moz-hidden-unscrollable;
      }
      .action-list-action-icon {
        display: inline;
        height: 18px;
        position: absolute;
        left: -18px;
        background-color: #fff;
        z-index: 3;
        margin-top: 1px;
        color: #999;
      }
      ol.actionList > li.pageviewActions {
        position: relative;
        margin-top: -6px;
      }
      li.pageviewActions > ol.actionList {
        margin-left: 1.5rem;
      }
      .pageviewActions.last-action > ol.actionList > li.last-action {
        margin-bottom: 0;
      }
    </style>
  @endif
@endsection

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Overzicht</a></li>
	</ol>
@endsection

@section('content')
<div class="container p3 min-height">
  @if(ChuckSite::getSetting('integrations.matomo-site-id') !== null && ChuckSite::getSetting('integrations.matomo-auth-key') !== null)
    @include('chuckcms::backend.dashboard.matomo')
  @else
    <div class="row">
      <div class="col-sm-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item active" aria-current="Overzicht">DASHBOARD</li>
          </ol>
        </nav>
        <div class="card-block">
          <header>
            <div class="row">
              <div class="col-12 mb-2">
                <div id="embed-api-auth-container"></div>
                <div id="view-name"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div id="view-selector-container"></div>
              </div>
              <div class="col-sm-6">
                <div id="active-users-container" class="h-100 pt-3 pb-4 text-center"></div>
              </div>
            </div>
          </header>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-lg-6 mb-3">
        <div class="card card-default">
          <div class="breadcrumb separator">
            <div class="breadcrumb-item">This Week vs Last Week (by sessions)</div>
          </div>
          <div class="card-block">
            <div class="Chartjs">
              <figure class="Chartjs-figure" id="chart-1-container"></figure>
              <ol class="Chartjs-legend" id="legend-1-container"></ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card card-default">
          <div class="breadcrumb separator">
            <div class="breadcrumb-item">This Year vs Last Year (by users)</div>
          </div>
          <div class="card-block">
            <div class="Chartjs">
              <figure class="Chartjs-figure" id="chart-2-container"></figure>
              <ol class="Chartjs-legend" id="legend-2-container"></ol>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-lg-6 mb-3">
        <div class="card card-default">
          <div class="breadcrumb separator">
            <div class="breadcrumb-item">Top Browsers (by pageview)</div>
          </div>
          <div class="card-block">
            <div class="Chartjs">
              <figure class="Chartjs-figure" id="chart-3-container"></figure>
              <ol class="Chartjs-legend" id="legend-3-container"></ol>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card card-default">
          <div class="breadcrumb separator">
            <div class="breadcrumb-item">Top Countries (by sessions)</div>
          </div>
          <div class="card-block">
            <div class="Chartjs">
              <figure class="Chartjs-figure" id="chart-4-container"></figure>
              <ol class="Chartjs-legend" id="legend-4-container"></ol>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  @endif
</div>
@endsection

@section('scripts')

@if(ChuckSite::getSetting('integrations.matomo-site-id') !== null && ChuckSite::getSetting('integrations.matomo-auth-key') !== null)
    @include('chuckcms::backend.dashboard.matomoscript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@else
<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>
<script>

  // == NOTE ==
  // This code uses ES6 promises. If you want to use this code in a browser
  // that doesn't supporting promises natively, you'll have to include a polyfill.
  
  gapi.analytics.ready(function() {
  
    /**
     * Authorize the user immediately if the user has already granted access.
     * If no access has been created, render an authorize button inside the
     * element with the ID "embed-api-auth-container".
     */
    gapi.analytics.auth.authorize({
      container: 'embed-api-auth-container',
      clientid: '470473657694-j0ni2qe642pcmtmmdac1p9smbhs8nb6o.apps.googleusercontent.com'
    });
  
  
    /**
     * Create a new ActiveUsers instance to be rendered inside of an
     * element with the id "active-users-container" and poll for changes every
     * five seconds.
     */
    var activeUsers = new gapi.analytics.ext.ActiveUsers({
      container: 'active-users-container',
      template:'<div class="ActiveUsers row h-100 mx-0 mb-3"> <span class="d-block w-100 mt-auto">Active Users:</span> <h1 class="d-block w-100 text-center my-0"><b class="ActiveUsers-value d-block text-center"></b></h1></div>',
      pollingInterval: 5
    });
  
  
    /**
     * Add CSS animation to visually show the when users come and go.
     */
    activeUsers.once('success', function() {
      var element = this.container.firstChild;
      var timeout;
  
      this.on('change', function(data) {
        var element = this.container.firstChild;
        var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
        element.className += (' ' + animationClass);
  
        clearTimeout(timeout);
        timeout = setTimeout(function() {
          element.className =
              element.className.replace(/ is-(increasing|decreasing)/g, '');
        }, 3000);
      });
    });
  
  
    /**
     * Create a new ViewSelector2 instance to be rendered inside of an
     * element with the id "view-selector-container".
     */
    var viewSelector = new gapi.analytics.ext.ViewSelector2({
      container: 'view-selector-container',
      template: '<div class="ViewSelector2">  <div class="ViewSelector2-item">    <label>Account</label>    <select class="FormField custom-select"></select>  </div>  <div class="ViewSelector2-item">    <label>Property</label>    <select class="FormField custom-select"></select>  </div>  <div class="ViewSelector2-item">    <label>View</label>    <select class="FormField custom-select"></select>  </div></div>',
    })
    .execute();
  
    const selectorFields = document.getElementsByClassName('FormField');
      for (var n = 0; n < selectorFields.length; n++) {
        selectorFields[n].classList.add('form-control');
      }
  
  
    /**
     * Update the activeUsers component, the Chartjs charts, and the dashboard
     * title whenever the user changes the view.
     */
    viewSelector.on('viewChange', function(data) {
      var title = document.getElementById('view-name');
      title.textContent = data.property.name + ' (' + data.view.name + ')';
  
      // Start tracking active users for this view.
      activeUsers.set(data).execute();
  
      // Render all the of charts for this view.
      renderWeekOverWeekChart(data.ids);
      renderYearOverYearChart(data.ids);
      renderTopBrowsersChart(data.ids);
      renderTopCountriesChart(data.ids);
    });
  
  
    /**
     * Draw the a chart.js line chart with data from the specified view that
     * overlays session data for the current week over session data for the
     * previous week.
     */
    function renderWeekOverWeekChart(ids) {
  
      // Adjust `now` to experiment with different days, for testing only...
      var now = moment(); // .subtract(3, 'day');
  
      var thisWeek = query({
        'ids': ids,
        'dimensions': 'ga:date,ga:nthDay',
        'metrics': 'ga:sessions',
        'start-date': moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
        'end-date': moment(now).format('YYYY-MM-DD')
      });
  
      var lastWeek = query({
        'ids': ids,
        'dimensions': 'ga:date,ga:nthDay',
        'metrics': 'ga:sessions',
        'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
            .format('YYYY-MM-DD'),
        'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
            .format('YYYY-MM-DD')
      });
  
      Promise.all([thisWeek, lastWeek]).then(function(results) {
  
        var data1 = results[0].rows.map(function(row) { return +row[2]; });
        var data2 = results[1].rows.map(function(row) { return +row[2]; });
        var labels = results[1].rows.map(function(row) { return +row[0]; });
  
        labels = labels.map(function(label) {
          return moment(label, 'YYYYMMDD').format('ddd');
        });
  
        var data = {
          labels : labels,
          datasets : [
            {
              label: 'Last Week',
              fillColor : 'rgba(220,220,220,0.5)',
              strokeColor : 'rgba(220,220,220,1)',
              pointColor : 'rgba(220,220,220,1)',
              pointStrokeColor : '#fff',
              data : data2
            },
            {
              label: 'This Week',
              fillColor : 'rgba(151,187,205,0.5)',
              strokeColor : 'rgba(151,187,205,1)',
              pointColor : 'rgba(151,187,205,1)',
              pointStrokeColor : '#fff',
              data : data1
            }
          ]
        };
  
        new Chart(makeCanvas('chart-1-container')).Line(data);
        generateLegend('legend-1-container', data.datasets);
      });
    }
  
  
    /**
     * Draw the a chart.js bar chart with data from the specified view that
     * overlays session data for the current year over session data for the
     * previous year, grouped by month.
     */
    function renderYearOverYearChart(ids) {
  
      // Adjust `now` to experiment with different days, for testing only...
      var now = moment(); // .subtract(3, 'day');
  
      var thisYear = query({
        'ids': ids,
        'dimensions': 'ga:month,ga:nthMonth',
        'metrics': 'ga:users',
        'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
        'end-date': moment(now).format('YYYY-MM-DD')
      });
  
      var lastYear = query({
        'ids': ids,
        'dimensions': 'ga:month,ga:nthMonth',
        'metrics': 'ga:users',
        'start-date': moment(now).subtract(1, 'year').date(1).month(0)
            .format('YYYY-MM-DD'),
        'end-date': moment(now).date(1).month(0).subtract(1, 'day')
            .format('YYYY-MM-DD')
      });
  
      Promise.all([thisYear, lastYear]).then(function(results) {
        var data1 = results[0].rows.map(function(row) { return +row[2]; });
        var data2 = results[1].rows.map(function(row) { return +row[2]; });
        var labels = ['Jan','Feb','Mar','Apr','May','Jun',
                      'Jul','Aug','Sep','Oct','Nov','Dec'];
  
        // Ensure the data arrays are at least as long as the labels array.
        // Chart.js bar charts don't (yet) accept sparse datasets.
        for (var i = 0, len = labels.length; i < len; i++) {
          if (data1[i] === undefined) data1[i] = null;
          if (data2[i] === undefined) data2[i] = null;
        }
  
        var data = {
          labels : labels,
          datasets : [
            {
              label: 'Last Year',
              fillColor : 'rgba(220,220,220,0.5)',
              strokeColor : 'rgba(220,220,220,1)',
              data : data2
            },
            {
              label: 'This Year',
              fillColor : 'rgba(151,187,205,0.5)',
              strokeColor : 'rgba(151,187,205,1)',
              data : data1
            }
          ]
        };
  
        new Chart(makeCanvas('chart-2-container')).Bar(data);
        generateLegend('legend-2-container', data.datasets);
      })
      .catch(function(err) {
        console.error(err.stack);
      });
    }
  
  
    /**
     * Draw the a chart.js doughnut chart with data from the specified view that
     * show the top 5 browsers over the past seven days.
     */
    function renderTopBrowsersChart(ids) {
  
      query({
        'ids': ids,
        'dimensions': 'ga:browser',
        'metrics': 'ga:pageviews',
        'sort': '-ga:pageviews',
        'max-results': 5
      })
      .then(function(response) {
  
        var data = [];
        var colors = ['#4D5360','#949FB1','#D4CCC5','#E2EAE9','#F7464A'];
  
        response.rows.forEach(function(row, i) {
          data.push({ value: +row[1], color: colors[i], label: row[0] });
        });
  
        new Chart(makeCanvas('chart-3-container')).Doughnut(data);
        generateLegend('legend-3-container', data);
      });
    }
  
  
    /**
     * Draw the a chart.js doughnut chart with data from the specified view that
     * compares sessions from mobile, desktop, and tablet over the past seven
     * days.
     */
    function renderTopCountriesChart(ids) {
      query({
        'ids': ids,
        'dimensions': 'ga:country',
        'metrics': 'ga:sessions',
        'sort': '-ga:sessions',
        'max-results': 5
      })
      .then(function(response) {
  
        var data = [];
        var colors = ['#4D5360','#949FB1','#D4CCC5','#E2EAE9','#F7464A'];
  
        response.rows.forEach(function(row, i) {
          data.push({
            label: row[0],
            value: +row[1],
            color: colors[i]
          });
        });
  
        new Chart(makeCanvas('chart-4-container')).Doughnut(data);
        generateLegend('legend-4-container', data);
      });
    }
    
    /**
     * Extend the Embed APIs `gapi.analytics.report.Data` component to
     * return a promise the is fulfilled with the value returned by the API.
     * @param {Object} params The request parameters.
     * @return {Promise} A promise.
     */
    function query(params) {
      return new Promise(function(resolve, reject) {
        var data = new gapi.analytics.report.Data({query: params});
        data.once('success', function(response) { resolve(response); })
            .once('error', function(response) { reject(response); })
            .execute();
      });
    }
  
  
    /**
     * Create a new canvas inside the specified element. Set it to be the width
     * and height of its container.
     * @param {string} id The id attribute of the element to host the canvas.
     * @return {RenderingContext} The 2D canvas context.
     */
    function makeCanvas(id) {
      var container = document.getElementById(id);
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext('2d');
  
      container.innerHTML = '';
      canvas.width = container.offsetWidth;
      canvas.height = container.offsetHeight;
      container.appendChild(canvas);
  
      return ctx;
    }
  
  
    /**
     * Create a visual legend inside the specified element based off of a
     * Chart.js dataset.
     * @param {string} id The id attribute of the element to host the legend.
     * @param {Array.<Object>} items A list of labels and colors for the legend.
     */
    function generateLegend(id, items) {
      var legend = document.getElementById(id);
      legend.innerHTML = items.map(function(item) {
        var color = item.color || item.fillColor;
        var label = item.label;
        return '<li><i style="background:' + color + '"></i>' +
            escapeHtml(label) + '</li>';
      }).join('');
    }
  
  
    // Set some global Chart.js defaults.
    Chart.defaults.global.animationSteps = 60;
    Chart.defaults.global.animationEasing = 'easeInOutQuart';
    Chart.defaults.global.responsive = true;
    Chart.defaults.global.maintainAspectRatio = false;
  
  
    /**
     * Escapes a potentially unsafe HTML string.
     * @param {string} str An string that may contain HTML entities.
     * @return {string} The HTML-escaped string.
     */
    function escapeHtml(str) {
      var div = document.createElement('div');
      div.appendChild(document.createTextNode(str));
      return div.innerHTML;
    }
  
  });
</script>
@endif

<!-- This demo uses the Chart.js graphing library and Moment.js to do date
     formatting and manipulation. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

<!-- Include the ViewSelector2 component script. -->
<script src="https://ga-dev-tools.appspot.com/public/javascript/embed-api/components/view-selector2.js"></script>

<!-- Include the DateRangeSelector component script. -->
<script src="https://ga-dev-tools.appspot.com/public/javascript/embed-api/components/date-range-selector.js"></script>

<!-- Include the ActiveUsers component script. -->
<script src="https://ga-dev-tools.appspot.com/public/javascript/embed-api/components/active-users.js"></script>

<!-- Include the CSS that styles the charts. -->
<link rel="stylesheet" href="https://ga-dev-tools.appspot.com/public/css/chartjs-visualizations.css">


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection