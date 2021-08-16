<div class="container-fluid bg-light px-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-none">
        <a class="navbar-brand" href="{{ ChuckSite::getSite('domain') }}"><img src="{{ ChuckSite::getSite('domain') }}{{ ChuckSite::getSetting('logo.href') }}" alt="{{ config('app.name', 'Laravel') }}" height="30"></a>
        <span class="navbar-text ml-auto d-inline-block d-lg-none mr-3">
            <div class="dropdown">
                <a class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" role="button" id="userMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="" data-src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" data-src-retina="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" width="32" height="32" class="rounded-circle"> {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuLink">
                    <a class="dropdown-item" href="https://support.chuck.be" target="_blank">Support</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </span>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar top-bar"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>               
        </button>

        <div class="collapse navbar-collapse font-weight-bold" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.pages') }}" class="nav-link">Paginas</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="topMenuBContentLink" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Navigatie <span class="caret"></span></a>
                    <div class="dropdown-menu" aria-labelledby="topMenuBContentLink">
                        <a class="dropdown-item" href="{{ route('dashboard.menus') }}">Menu's</a>
                        <a class="dropdown-item" href="{{ route('dashboard.redirects') }}">Redirects</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="topMenuAContentLink" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gebruikers <span class="caret"></span></a>
                    <div class="dropdown-menu" aria-labelledby="topMenuAContentLink">
                        <a class="dropdown-item" href="{{ route('dashboard.users') }}">Overzicht</a>
                        <a class="dropdown-item" href="{{ route('dashboard.users.roles') }}">Rollen & Rechten</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.templates') }}" class="nav-link">Templates</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.forms') }}" class="nav-link">Formulieren</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="topMenuContentLink" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Content <span class="caret"></span></a>
                    <div class="dropdown-menu" aria-labelledby="topMenuContentLink">
                        <a class="dropdown-item" href="{{ route('unisharp.lfm.show') }}">Media</a>
                        <a class="dropdown-item" href="{{ route('dashboard.content.resources') }}">Resources</a>
                        <a class="dropdown-item" href="{{ route('dashboard.content.repeaters') }}">Repeaters</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.settings') }}" class="nav-link">Instellingen</a>
                </li>
            </ul>
            <span class="navbar-text ml-auto d-none d-lg-inline-block">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" role="button" id="userMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="" data-src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" data-src-retina="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" width="32" height="32" class="rounded-circle"> <small>{{ Auth::user()->name }} <span class="caret"></span></small>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuLink">
                        <a class="dropdown-item" href="https://support.chuck.be" target="_blank">Support</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                    </div>
                </div>
            </span>
        </div>
    </nav>

    @if($modules !== null)
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <span class="navbar-text d-sm-none ml-auto mt-2">MODULES</span>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#subNavbarSupportedContent" aria-controls="subNavbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar top-bar"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>               
        </button>

        <div class="collapse navbar-collapse font-weight-bold" id="subNavbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @foreach($modules as $module)
                @if($module->json['admin']['show_in_menu'] == true)
                <li class="nav-item{{ $module->json['admin']['menu']['has_submenu'] ? ' dropdown' : '' }}">
                    @if($module->json['admin']['menu']['has_submenu'] == true)
                    <a href="#" class="nav-link dropdown-toggle" id="moduleMenuLink{{ $module->slug }}" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $module->json['admin']['menu']['name'] }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="moduleMenuLink{{ $module->slug }}">
                        @foreach($module->json['admin']['menu']['submenu'] as $submenuKey => $submenu)
                        @if($submenu['has_submenu'] == true)
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">{{ $submenu['name'] }}</a>
                            @if($submenu['has_submenu'] == true)
                            <ul class="dropdown-menu">
                                @foreach($submenu['submenu'] as $subsubmenuKey => $subsubmenu)
                                <li><a class="dropdown-item" href="{{ route($subsubmenu['route']) }}">{{ $subsubmenu['name'] }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                            
                        </li>
                        @else
                        <li><a class="dropdown-item" href="{{ route($submenu['route']) }}">{{ $submenu['name'] }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                    @else
                    <a href="{{ route($module->json['admin']['menu']['route']) }}" class="nav-link">{{ $module->json['admin']['menu']['name'] }}</a>
                    @endif
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </nav>
    @endif
</div>