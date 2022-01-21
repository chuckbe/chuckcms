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
<div class="row mb-3 matomodash">
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
              <ul class="referrerslist pl-1"></ul>
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
  </div>
</div>