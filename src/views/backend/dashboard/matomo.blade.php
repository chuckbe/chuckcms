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
  </div>
</div>

<div class="row mb-3">
  <div class="col-lg-3 d-md-block sidebar collapse">
    <div class="card shadow">
      <nav id="sidebarMenu">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item sidebar-dropdown-menu active">
              <a class="nav-link text-dark font-weight-bold" href="#" data-category="visitors">
                <span class="menu-icon icon-reporting-visitors"></span> Visitors
              </a>
              <ul class="sidebar-sub-menu p-0 m-0">
                <li><a class="text-dark" href="#" data-link="overview">Overview</a></li>
                <li class="active"><a class="text-dark" href="#" data-link="visitor Log">Visitor Log</a></li>
              </ul>
            </li>
            <li class="nav-item sidebar-dropdown-menu">
              <a class="nav-link text-dark font-weight-bold active" href="#" data-category="heatmaps">
                <span class="menu-icon icon-drop"></span> Heatmaps
              </a>
              <ul class="sidebar-sub-menu p-0 m-0">
                
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="col-lg-9 menu-items-content">
    <div class="matomo-items" data-item='overview'>
      <h3 class="lead">Overview</h3>
      <ul id="visitoroverviewcards" class="m-0 p-0">
        <li class="card shadow my-3 p-3">
          <h3 class="lead font-weight-bold">Visits Overview</h3>
          <ul id="visitsoverview"></ul>
        </li>
      </ul>
    </div>
    <div class="matomo-items active" data-item='visitor Log'>
      <h3 class="lead">Visits Log</h3>
      <ul id="visitorcards" class="m-0 p-0"></ul>
      <nav><ul class="pagination justify-content-end pagination-sm"></ul></nav>
    </div>



    {{-- heatmaps --}}
    <div class="matomo-items" data-item='heatmap'>
      <h3 class="lead">Heatmap</h3>
      <ul id="Heatmapcards" class="m-0 p-0"></ul>
    </div>
  </div>
</div>

{{-- <div class="row mb-3">
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
</div> --}}
<div class="modal modal-visitor-profile-info fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="visitor-profile-overview col-7">
            <div class="w-100">
              <div class="row mx-0">
                <div class="visitor-profile-avatar pr-2">
                  <img src="https://analytics.chuck.be/plugins/Live/images/unknown_avatar.png" alt="" title="">
                </div>
                <div class="visitor-profile-header pl-2">
                  <h1>Visitor profile</h1>
                  <div class="visitor-profile-id">
                    <span>ID</span>
                  </div>
                  <span class="visitorLogIcons">
                    <span class="visitorDetails">
                    </span>
                  </span>               
                </div>
                <div class="visitor-profile-summary visitor-profile-resume py-4">
                  <h2>Summary</h2>
                  <div class="summary">
                    <p>
                      Spent a total of <strong>1 min 10s</strong> on the website, and viewed 
                      <strong title="9 Unique Pageviews, 0 Pages viewed more than once">9 pages</strong> 
                      in <strong>2 visits</strong>.
                    </p>
                  </div>
                  <h2 class="mt-3">Ecommerce</h2>
                  <div class="ecommerce">
                    <p>
                      Spent a total of <strong>1 min 10s</strong> on the website, and viewed 
                      <strong title="9 Unique Pageviews, 0 Pages viewed more than once">9 pages</strong> 
                      in <strong>2 visits</strong>.
                    </p>
                  </div>
                  <div class="row mt-3 firstlastvisit">
                    
                  </div>
                  <h2 class="mt-3">Devices</h2>
                  <div class="devices">
                  </div>
                  <h2 class="mt-3">Location</h2>
                  <div class="location">
                  </div>


                </div>
              </div>
            </div>
          </div>
          <div class="visitor-profile-visits-info col-5">

          </div>
        </div>

      </div>
    </div>
  </div>
</div>