<div class="row">
  <div class="col-sm-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item active" aria-current="Overzicht">DASHBOARD</li>
        <div class="ml-auto">
          <div class="btn bg-white px-2 py-1 border" id="reportrange">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
          </div>
        </div>
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
  <div class="col-lg-12">
    <h3 class="lead">Visitor Log</h3>
      <ul id="visitorcards" class="m-0 p-0">
        
      </ul>
      <nav>
        <ul class="pagination justify-content-center pagination-sm">
        </ul>
      </nav>
  </div>
</div>

<div class="row mb-3">
    <div class="col-lg-4 mb-3">
        <div class="card card-default">
            <div class="breadcrumb separator">
                <div class="breadcrumb-item">Real Time Visitor Count</div>
            </div>
            <div class="card-block text-center">
                <div class="bg-light rounded px-1 py-3" style="margin: 0 30%">
                    <span class="font-weight-bold" style="font-size:2rem;" id="LiveVisitors"></span>
                </div>
                <p class="pt-3">
                    <span id="counter-visitor" class="font-weight-bold"></span> and <span id="counter-actions" class="font-weight-bold"></span><br> in Last 20 seconds
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
    <div class="col-lg-12 mb-3">
            <div class="card card-default">
                <div class="breadcrumb separator">
                    <div class="breadcrumb-item">sessions</div>
                </div>
                <div class="card-block">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>