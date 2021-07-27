<div class="container p3 min-height">
	
	<div class="row mb-3">
		<div class="col-sm-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mt-3">
					<li class="breadcrumb-item active" aria-current="Overzicht">Matomo Dashboard <span id="mVersion"></span></li>
					<div class="ml-auto">
					<div class="btn bg-white px-2 py-1 border" id="reportrange">
						<i class="fa fa-calendar"></i>&nbsp;
						<span></span> <i class="fa fa-caret-down"></i>
					</div>
					<div class="btn bg-white px-2 py-1 border" id="matomoSettings" data-toggle="modal" data-target="#settingsmodal">
						<i class="fa fa-cog"></i>
					</div>
					</div>
				</ol>
			</nav>
		</div>
  	</div>
	<div class="row mb-3">
		<div class="col-lg-12 mb-3">
				<div class="card card-default">
					<div class="breadcrumb separator">
						<div class="breadcrumb-item">sessions</div>
					</div>
					<div class="card-block">
						{{-- <ul id="sessions" style="list-style: none;"></ul> --}}
						<div class="sessions-table table-responsive">
							<table class="table table-hover" id="table" data-show-header="true" data-pagination="true" data-page-size="5">
							<thead>
								<tr>
									<th scope="col" class="border-top-0">Url</th>
									<th scope="col" class="border-top-0">Pageviews</th>
									<th scope="col" class="border-top-0">Time</th>
									<th scope="col" class="border-top-0">Time on website</th>
									<th scope="col" class="border-top-0">Location</th>
									<th scope="col" class="border-top-0">Device</th>
									<th scope="col" class="border-top-0">OS</th>
									<th scope="col" class="border-top-0">Browser</th>
								</tr>
							</thead>
			  				<tbody id="table_body_sessions">
							</tbody>
							<nav aria-label="Page navigation example">
								<ul class="pagination">
									<li class="page-item">
									<a class="page-link" href="#" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
										<span class="sr-only">Previous</span>
									</a>
									</li>
									<li class="page-item"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item">
									<a class="page-link" href="#" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
										<span class="sr-only">Next</span>
									</a>
									</li>
								</ul>
							</nav>
						</table>
					</div>
				</div>
			</div>
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
					<div class="breadcrumb-item">Top Countries</div>
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
<div class="modal" id="settingsmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Matomo Settings</h5>
        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> --}}
      </div>
      <div class="modal-body">
        <form id="matomodata" action="{{ route('dashboard.matomosubmit') }}" method="post">
			@csrf
			<div class="row">
				<div class="form-group col-md-12">
					<label class="sr-only" for="site-id">Site Id</label>
					<div class="d-flex align-items-center border pl-3">
						<i class="fa fa-id-card icon"></i>
						<input class="form-control border-0" type="text" name="siteId" id="siteId" placeholder="Site Id*" value="{{empty($matomoSiteId) || $matomoSiteId == null ? '' : $matomoSiteId}}" required>
					</div>
            	</div>
				<div class="form-group col-md-12">
					<label class="sr-only" for="auth-token">AUTH_TOKEN</label>
					<div class="d-flex align-items-center border pl-3">
						<i class="fa fa-key icon"></i>
						<input class="form-control border-0" type="text" name="authtoken" id="authToken" placeholder="AUTH_TOKEN*" value="{{empty($matomoAuthToken) || $matomoAuthToken == null ?  '' : $matomoAuthToken}}" required>
					</div>
            	</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
		@endif
		<button type="submit" name="send" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>