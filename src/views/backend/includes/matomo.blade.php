<div class="container p3 min-height">
	<div class="row mb-3">
		<div class="col-sm-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mt-3">
					<li class="breadcrumb-item active" aria-current="Overzicht">Matomo Dashboard <span id="mVersion"></span></li>
					<div class="btn bg-white px-2 py-1 border ml-auto" id="reportrange">
						<i class="fa fa-calendar"></i>&nbsp;
						<span></span> <i class="fa fa-caret-down"></i>
					</div>
				</ol>
			</nav>
		</div>
  	</div>
	<div class="row mb-3">
		<div class="col-lg-6 mb-3">
			<div class="card card-default">
				<div class="breadcrumb separator">
					<div class="breadcrumb-item">Real Time Visitor Count</div>
				</div>
				<div class="card-block text-center">
					<div class="bg-light rounded px-1 py-5" style="margin: 0 30%">
						<span class="font-weight-bold" style="font-size:2rem;" id="LiveVisitors"></span>
					</div>
					<p class="pt-3">
						<span id="counter-visitor" class="font-weight-bold"></span> and <span id="counter-actions" class="font-weight-bold"></span> in Last 20 seconds
					</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-3">
			<div class="card card-default">
				<div class="breadcrumb separator">
					<div class="breadcrumb-item">Info</div>
				</div>
				<div class="card-block p-3">
					<p><strong>Average Bounce Rate:</strong> <span id="avgBouceRate"></span></p>
					<p><strong>Total visits:</strong> <span id="totalVisits"></span></p>
					<p><strong>Average Time spend by a user on site:</strong> <span id="avgTimeSpend"></span></p>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-lg-6 mb-3">
				<div class="card card-default">
					<div class="breadcrumb separator">
						<div class="breadcrumb-item">Visits over Time</div>
					</div>
					<div class="card-block">
						<div id="chartVisitors"></div>
						<div class="Chartjs">
						<figure class="Chartjs-figure" id="chart-1-container"></figure>
							<ol class="Chartjs-legend" id="legend-1-container" style="display: none;">
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 mb-3">
				<div class="card card-default">
					<div class="breadcrumb separator">
						<div class="breadcrumb-item">Referers</div>
					</div>
					<div class="card-block">
						<ul id="searchenginereferer"></ul>
					</div>
			</div>
		</div>
	</div>
  	<div class="row mb-3">
		<div class="col-lg-6 mb-3">
				<div class="card card-default">
					<div class="breadcrumb separator">
						<div class="breadcrumb-item">Popular OS</div>
					</div>
					<div class="card-block">
						<ul id="PopularOs" style="list-style: none;"></ul>
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
					  <ol class="Chartjs-legend" id="countriesList"></ol>
				  </div>
			  </div>
		  </div>
    	</div>
  	</div>
</div>