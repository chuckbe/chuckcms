@extends('chuckcms::backend.layouts.base')

@section('title')
	Matomo
@endsection

@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
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
  @if (session('notification'))
      @include('chuckcms::backend.includes.notification')
  @endif
  <script>
    let chartData1 = $('#legend-1-container').text();
    let chartFigure1 = $('#chart-1-container');
    let uniqueVisitorsCanvas = $('<canvas/>',{
                   'class':'px-3',
                    id: 'chart-1-container-canvas'                   
                });
    $(chartFigure1).append(uniqueVisitorsCanvas);
    let Chart1 = new Chart(uniqueVisitorsCanvas[0].getContext('2d'), {
        type: 'line',
        data: {
            datasets: [{
                data: [0,chartData1],
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
  </script>
@endsection

@section('content')
@include('chuckcms::backend.includes.matomo')
@endsection