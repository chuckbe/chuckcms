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
            {{-- <li class="nav-item sidebar-dropdown-menu">
              <a class="nav-link text-dark font-weight-bold active" href="#" data-category="heatmaps">
                <span class="menu-icon icon-drop"></span> Heatmaps
              </a>
              <ul class="sidebar-sub-menu p-0 m-0"></ul>
            </li>
            <li class="nav-item sidebar-dropdown-menu">
              <a class="nav-link text-dark font-weight-bold active" href="#" data-category="sessionrecordings">
                <span class="menu-icon icon-play"></span> Session Recordings
              </a>
              <ul class="sidebar-sub-menu p-0 m-0"></ul>
            </li> --}}
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="col-lg-9 menu-items-content">
    <div class="loader w-100 h-100 bg-white position-absolute text-center pt-5" style="z-index: 100;">
      <svg width="60" height="100" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#ccc">
          <rect y="10" width="15" height="120" rx="6">
              <animate attributeName="height"
                  begin="0.5s" dur="1s"
                  values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                  repeatCount="indefinite" />
              <animate attributeName="y"
                  begin="0.5s" dur="1s"
                  values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                  repeatCount="indefinite" />
          </rect>
          <rect x="30" y="10" width="15" height="120" rx="6">
              <animate attributeName="height"
                  begin="0.25s" dur="1s"
                  values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                  repeatCount="indefinite" />
              <animate attributeName="y"
                  begin="0.25s" dur="1s"
                  values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                  repeatCount="indefinite" />
          </rect>
          <rect x="60" width="15" height="140" rx="6">
              <animate attributeName="height"
                  begin="0s" dur="1s"
                  values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                  repeatCount="indefinite" />
              <animate attributeName="y"
                  begin="0s" dur="1s"
                  values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                  repeatCount="indefinite" />
          </rect>
          <rect x="90" y="10" width="15" height="120" rx="6">
              <animate attributeName="height"
                  begin="0.25s" dur="1s"
                  values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                  repeatCount="indefinite" />
              <animate attributeName="y"
                  begin="0.25s" dur="1s"
                  values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                  repeatCount="indefinite" />
          </rect>
          <rect x="120" y="10" width="15" height="120" rx="6">
              <animate attributeName="height"
                  begin="0.5s" dur="1s"
                  values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                  repeatCount="indefinite" />
              <animate attributeName="y"
                  begin="0.5s" dur="1s"
                  values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                  repeatCount="indefinite" />
          </rect>
      </svg>

    </div>
    <div class="matomo-items" data-item='overview'>
      <h3 class="lead">Overview</h3>
      <div id="visitoroverviewcards" class="m-0 p-0 row">
        
        <div class="col-12 col-lg-3">
          <div class="card shadow my-3 p-3">
            <div id="liveVisitors">
              <h3 class="lead font-weight-bold  text-center">Real Time Visitor Count</h3>
              <div class="simple-realtime-visitor-counter" title="0 visitors">
                  <span>0</span>
              </div>
              <div class="simple-realtime-elaboration">
                <span><strong>0 visits</strong> and <strong>0 actions</strong> in the last <strong>3 minutes</strong></span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-9">
          <div class="card shadow my-3 p-3">
            <div id="referrers">
              <h3 class="lead font-weight-bold">Referrers</h3>
              <ul class="referrerslist pl-1">

              </ul>
            </div>
          </div>
        </div>

        
        <div class="col-12 col-lg-12">
          <div class="card shadow my-3 p-3">
            <h3 class="lead font-weight-bold">Visits Overview</h3>
            <div id="visitsoverview" class="mt-4 mx-0 row"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="matomo-items active" data-item='visitor Log'>
      <h3 class="lead">Visits Log</h3>
      <ul id="visitorcards" class="m-0 p-0"></ul>
      <nav><ul class="pagination pagination-visitors justify-content-end pagination-sm"></ul></nav>
    </div>

    {{-- heatmaps --}}
    <div class="matomo-items" data-item='heatmap'>
      <h3 class="lead">Heatmap</h3>
      <ul id="Heatmapcards" class="m-0 p-0"></ul>
    </div>

    <div class="matomo-items" data-item='sessionrecordings'>
      <h3 class="lead">Session recording</h3>
      <table id="sessionrecordings" data-paging="true" class="table table-bordered table-hover footable">
        <thead>
            <tr>
                <th>ENTRY URL → EXIT URL</th>
                <th>PAGEVIEWS</th>
                <th>TIME</th>
                <th>TIME ON WEBSITE</th>
                <th>LOCATION</th>
                <th>DEVICE</th>
                <th>OS</th>
                <th>BROWSER</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal modal-visitor-profile-info fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
      <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button> --}}
      </div>
      <div class="modal-body py-0">
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