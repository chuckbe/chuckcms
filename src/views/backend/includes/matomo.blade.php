<div class="container p3 min-height">
  <div class="row mb-3">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item active" aria-current="Overzicht">Matomo Dashboard</li>
            </ol>
        </nav>
        <div class="card-block">
            <header>
                <div class="row">
                    <div class="col-12">
						<div class="card card-default matomoIntroData">
							<div class="breadcrumb separator">
								<div class="breadcrumb-item">
									Data: 
									<select class="mx-2" name="period" id="period">
										<option value="today">Today</option>
										<option value="week">Last week</option>
										<option value="month">This Month</option>
										<option value="year">This Year</option>
									</select>
								</div>
							</div>
							<div data-summary="today" style="display: none;" class="card-block p-3">
								<p><strong>Average Bounce Rate today:</strong> {{$matomoSummaryToday->bounce_rate}}</p>
								<p><strong>Total visits today:</strong> {{$matomoSummaryToday->nb_visits}}</p>
								<p><strong>Average Time spend by a user on site today:</strong> {{number_format((float)($matomoSummaryToday->avg_time_on_site)/60, 2,'.', '')}}{{($matomoSummaryToday->avg_time_on_site)/60 > 1 ? " Minutes": " Minute"}} </p>
							</div>
							<div data-summary="week" style="display: none;" class="card-block p-3">
								<p><strong>Average Bounce Rate this week:</strong> {{$matomoSummaryWeek->bounce_rate}}</p>
								<p><strong>Total visits this week:</strong> {{$matomoSummaryWeek->nb_visits}}</p>
								<p><strong>Average Time spend by a user on site this week:</strong> {{number_format((float)($matomoSummaryWeek->avg_time_on_site)/60, 2,'.', '')}}{{($matomoSummaryWeek->avg_time_on_site)/60 > 1 ? " Minutes": " Minute"}} </p>
							</div>
							<div data-summary="month" style="display: none;" class="card-block p-3">
								<p><strong>Average Bounce Rate this month:</strong> {{$matomoSummaryMonth->bounce_rate}}</p>
								<p><strong>Total visits this month:</strong> {{$matomoSummaryMonth->nb_visits}}</p>
								<p><strong>Average Time spend by a user on site this month:</strong> {{number_format((float)($matomoSummaryMonth->avg_time_on_site)/60, 2,'.', '')}}{{($matomoSummaryMonth->avg_time_on_site)/60 > 1 ? " Minutes": " Minute"}} </p>
							</div>
							<div data-summary="year" style="display: none;" class="card-block p-3">
								<p><strong>Average Bounce Rate in last 1 year:</strong> {{$matomoSummaryYear->bounce_rate}}</p>
								<p><strong>Total visits in last 1 year:</strong> {{$matomoSummaryYear->nb_visits}}</p>
								<p><strong>Average Time spend by a user on site in last 1 year:</strong> {{number_format((float)($matomoSummaryYear->avg_time_on_site)/60, 2,'.', '')}}{{($matomoSummaryYear->avg_time_on_site)/60 > 1 ? " Minutes": " Minute"}} </p>
							</div>
						</div>
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
					<div class="breadcrumb-item">Unique visitors Last Week</div>
				</div>
				<div class="card-block">
					<div class="Chartjs">
					  <figure class="Chartjs-figure" id="chart-1-container"></figure>
					  <ol class="Chartjs-legend" id="legend-1-container" style="display: none;">
					  @foreach ($matomoUniqueVisitorsWeek as $UniqueVisitors)
						  <li>{{$UniqueVisitors}}</li>
					  @endforeach
					  </ol>
				  </div>
			  </div>
		  </div>
    </div>
	<div class="col-lg-6">
			<div class="card card-default">
				<div class="breadcrumb separator">
					<div class="breadcrumb-item">Top Countries Today</div>
				</div>
				<div class="card-block">
					<div class="Chartjs">
					  <figure class="Chartjs-figure" id="chart-4-container"></figure>
					  <ol class="Chartjs-legend" id="legend-4-container">
					  	@foreach ($matomoContries as $countries)
							@if($countries->nb_uniq_visitors > 0)
						  		<li>{{$countries->label}}: {{$countries->nb_uniq_visitors}} Visitors</li>
						  	@endif
						@endforeach
						</ol>
				  </div>
			  </div>
		  </div>
    </div>
    <div class="col-lg-6">
			<div class="card card-default">
				<div class="breadcrumb separator">
					<div class="breadcrumb-item">Visitor Map Today</div>
				</div>
				<div class="card-block">
					<div class="Chartjs">
					  <figure class="Chartjs-figure" id="chart-2-container"></figure>
					  <ol class="Chartjs-legend" id="legend-2-container" style="display: none;">
					  	@foreach ($matomoContries as $countries)
							@if($countries->nb_uniq_visitors > 0)
						  		<li data-daily-uniq-visitors={{$countries->nb_uniq_visitors}} data-code= {{$countries->code}}>{{$countries->label}}</li>
						  	@endif
						@endforeach
					  </ol>
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
					<div class="breadcrumb-item">Top Countries Today</div>
				</div>
				<div class="card-block">
					<div class="Chartjs">
					  <figure class="Chartjs-figure" id="chart-4-container"></figure>
					  <ol class="Chartjs-legend" id="legend-4-container">
					  	@foreach ($matomoContries as $countries)
							@if($countries->nb_uniq_visitors > 0)
						  		<li>{{$countries->label}}: {{$countries->nb_uniq_visitors}} Visitors</li>
						  	@endif
						@endforeach
						</ol>
				  </div>
			  </div>
		  </div>
    </div>
    
  </div>
</div>