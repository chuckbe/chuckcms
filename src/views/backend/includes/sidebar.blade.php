    <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        <img src="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" alt="logo" class="brand" data-src="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" data-src-retina="{{ URL::to('chuckbe/chuckcms/chuckcms-logo.png') }}" height="22">
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 ">
            <a href="{{ route('dashboard') }}">
              <span class="title">Dashboard</span>
            </a>
            <span class="icon-thumbnail"><i data-feather="shield"></i></span>
          </li>

          <li class="">
            <a href="{{ route('dashboard.pages') }}"><span class="title">Paginas</span></a>
            <span class="icon-thumbnail"><i data-feather="layout"></i></span>
          </li>

          <li class="">
            <a href="javascript:;"><span class="title">Navigatie</span>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i data-feather="list"></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route('dashboard.menus') }}">Menu's</a>
                <span class="icon-thumbnail">me</span>
              </li>
              <li class="">
                <a href="{{ route('dashboard.redirects') }}">Redirects</a>
                <span class="icon-thumbnail">re</span>
              </li>
            </ul>
          </li>

          <li class="">
            <a href="javascript:;"><span class="title">Gebruikers</span>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i data-feather="users"></i></span>
            <ul class="sub-menu">
              @can('show users')
              <li class="">
                <a href="{{ route('dashboard.users') }}">Overzicht</a>
                <span class="icon-thumbnail"><i data-feather="users"></i></span>
              </li>
              @endcan
              @can('show roles')
              <li class="">
                <a href="{{ route('dashboard.users.roles') }}">Rollen & Rechten</a>
                <span class="icon-thumbnail"><i data-feather="shield"></i></span>
              </li>
              @endcan
            </ul>
          </li>
          @can('show templates')
          <li class="">
            <a href="{{ route('dashboard.templates') }}"><span class="title">Templates</span></a>
            <span class="icon-thumbnail"><i data-feather="grid"></i></span>
          </li>
          @endcan

          <li class="">
            <a href="{{ route('dashboard.forms') }}"><span class="title">Formulieren</span></a>
            <span class="icon-thumbnail"><i data-feather="clipboard"></i></span>
          </li>

          <li class="">
            <a href="javascript:;"><span class="title">Content</span>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i data-feather="box"></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="{{ route('unisharp.lfm.show') }}">Media</a>
                <span class="icon-thumbnail"><i data-feather="airplay"></i></span>
              </li>
              <li class="">
                <a href="{{ route('dashboard.content.resources') }}">Resources</a>
                <span class="icon-thumbnail">re</span>
              </li>
              <li class="">
                <a href="{{ route('dashboard.content.repeaters') }}">Repeaters</a>
                <span class="icon-thumbnail">rp</span>
              </li>
            </ul>
          </li>

          <li class="">
            <a href="{{ route('dashboard.settings') }}">
              <span class="title">Instellingen</span>
            </a>
            <span class="icon-thumbnail"><i data-feather="cpu"></i></span>
          </li>

          <li class="">
            <hr>
          </li>

          @foreach($modules as $module)
            @if($module->json['admin']['show_in_menu'] == true)
            <li class="">
              @if($module->json['admin']['menu']['has_submenu'] == true)
              <a href="javascript:;">
              @else
              <a href="{{ route($module->json['admin']['menu']['route']) }}">
              @endif
              <span class="title">{{ $module->json['admin']['menu']['name'] }}</span>
              @if($module->json['admin']['menu']['has_submenu'] == true)
              <span class="arrow"></span>
              @endif
              </a>
              <span class="icon-thumbnail"><i data-feather="{{ $module->json['admin']['menu']['icon'] }}"></i></span>
              @if($module->json['admin']['menu']['has_submenu'] == true)
              <ul class="sub-menu">
                @foreach($module->json['admin']['menu']['submenu'] as $submenuKey => $submenu)
                <li class="">
                  @if($submenu['has_submenu'] == true)
                  <a href="javascript:;">
                  @else
                  <a href="{{ route($submenu['route']) }}">
                  @endif
                  <span class="title">{{ $submenu['name'] }}</span>
                  @if($submenu['has_submenu'] == true)
                  <span class="arrow"></span>
                  @endif
                  </a>
                  <span class="icon-thumbnail">
                    @if($submenu['icon'] == true)
                    <i data-feather="{{ $submenu['icon_data'] }}"></i>
                    @else
                    {{ $submenu['icon_data'] }}
                    @endif
                  </span>
                  @if($submenu['has_submenu'] == true)
                  <ul class="sub-menu">
                    @foreach($submenu['submenu'] as $subsubmenuKey => $subsubmenu)
                    <li class="">
                      <a href="{{ route($subsubmenu['route']) }}">{{ $subsubmenu['name'] }}</a>
                      <span class="icon-thumbnail">
                        @if($subsubmenu['icon'] == true)
                        <i data-feather="{{ $subsubmenu['icon_data'] }}"></i>
                        @else
                        {{ $subsubmenu['icon_data'] }}
                        @endif
                      </span>
                    </li>
                    @endforeach
                  </ul>
                  @endif
                </li>
                @endforeach
              </ul>
              @endif
            </li>
            @endif
          @endforeach
          
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->