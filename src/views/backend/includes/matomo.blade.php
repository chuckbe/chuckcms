<div class="container p3 min-height">
  <div class="row mb-3">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item active" aria-current="Overzicht">Matomo Dashboard</li>
            </ol>
        </nav>
        {{-- <div class="card-block">
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
		</div> --}}
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-lg-6 mb-3">
			<div class="card card-default">
				<div class="breadcrumb separator">
					<div class="breadcrumb-item">Unique visitors Today</div>
				</div>
				<div class="card-block">
					<div class="Chartjs">
					  <figure class="Chartjs-figure" id="chart-1-container"></figure>
					  <ol class="Chartjs-legend" id="legend-1-container">{{$matomoUniqueVisitorsToday}}</ol>
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
</div>