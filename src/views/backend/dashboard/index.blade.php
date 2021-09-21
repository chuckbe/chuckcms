@extends('chuckcms::backend.layouts.base')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
	Dashboard
@endsection
@section('css')
  @if(ChuckSite::getSetting('integrations.matomo-site-id') !== null && ChuckSite::getSetting('integrations.matomo-auth-key') !== null)
    <link href="{{ asset('chuckbe/chuckcms/css/matomo.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.6/footable.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.6/footable.core.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
    .heatmapcard:not(.active){
      display: none
    }
    .heatmapcard iframe{
      border: none;
      width: 100%;
      min-height: 525px;
    }
    .heatmapcard iframe html{
      width: 100%;
      overflow: scroll;
    }
    .heatmapVis{
      width: 100%;
    }
    .legendOuter{
      display: block !important;
    }
    #ng-app .heatmapVis iframe,
    #ng-app .hsrLoadingOuter,
    #ng-app .iframeRecordingContainer,
    #ng-app #recordingPlayer {
      width: 100% !important;
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
    <div id="map"></div>
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


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.6/footable.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.6/footable.core.min.js"></script>

@endsection