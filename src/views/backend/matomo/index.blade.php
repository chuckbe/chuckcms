@extends('chuckcms::backend.layouts.base')

@section('title')
	Matomo
@endsection

@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.1.1/dist/svgMap.min.css" rel="stylesheet">
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
  <script>
  $(function() {
    let chartData1 = $('#legend-1-container').find("li");
    let chartData2 = $('#legend-2-container').find("li");
    let data = [];
    let countryData = [];
    $.each($(chartData1),function(){
      data.push(parseInt($(this).text()));
    });
    $.each($(chartData2),function(){
      countryData.push({
        "country" : $(this).text(),
        "daily_unique_visitors": parseInt($(this).attr("data-daily-uniq-visitors")),
        "country_code": $(this).attr("data-code")
        });
    });
    let countries = {
      data: {
        uniqueVisitors: {
          name: 'visitors',
          format: '{0} visitors',
          thousandSeparator: '.'
        }
      },
      applyData: 'uniqueVisitors',
      values : {}
    }
    $.each($(chartData2),function(){
      let d = {uniqueVisitors :  parseInt($(this).attr("data-daily-uniq-visitors"))};
      countries['values'][$(this).attr("data-code").toUpperCase()] = d;
    });

    let days = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vridag', 'Zaterdag', 'Zondag'];
    let goBackDays = 7;
    let yesterday = new Date()
    yesterday.setDate(yesterday.getDate() - 1);
    let daysSorted = [];
    for(let i = 0; i < goBackDays; i++) {
      let newDate = new Date(yesterday.setDate(yesterday.getDate() - 1));
      daysSorted.push(days[newDate.getDay()]);
    }
    
    let chartFigure1 = $('#chart-1-container');
    let chartFigure2 = $('#chart-2-container');
    let uniqueVisitorsCanvas = $('<canvas/>',{
                   'class':'px-3',
                    id: 'chart-1-container-canvas'                   
                });
    let countriesCanvas = $('<div/>',{
                   'class':'px-3',
                    id: 'chart-2-container-div'                   
                });
    $(chartFigure1).append(uniqueVisitorsCanvas);
    // $(chartFigure2).append(countriesCanvas);
    let Chart1 = new Chart(uniqueVisitorsCanvas[0].getContext('2d'), {
        type: 'line',
        data: {
            labels: daysSorted.reverse(),
            datasets: [{
                label: 'unique visitors',
                data: data,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
              display: false
            },
            tooltips: {
              callbacks: {
                title: function() {}
              }
            }
        }
    });
    let choosePeriod = $('.matomoIntroData #period').val();
    $(`.matomoIntroData div[data-summary=${choosePeriod}]`).show();
    $('.matomoIntroData #period').on('change', function(){
      let period = $(this).val();
      $.each($(`.matomoIntroData div[data-summary]`),function(){
        $(this).hide();
      });
      $(`.matomoIntroData div[data-summary=${period}]`).show();
    })

  //   new svgMap({
  //                   targetElementID: 'chart-2-container-div',
  //                   countryNames: svgMapCountryNamesEN,
  //                   data: countries,
  //                   colorMin: '#FFF',
  //                   colorMax: '#730B62',
  //                   hideFlag: false,
  //                   noDataText: 'Geen bezoekers'
  //             });
  
  
  //   map = $K.map(chartFigure2, 600, 400);
  //   map.loadMap('/chuckbe/chuckcms/world.svg', function() {
  //    map.addLayer({
  //       id: "countries",
  //       key: "iso3"
  //     })
  //   });
  });
  </script>
@endsection

@section('content')
@include('chuckcms::backend.includes.matomo')
@endsection