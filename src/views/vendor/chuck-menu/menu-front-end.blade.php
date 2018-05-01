@if(isset($menus))
<ul class="nav navbar-nav">
    @foreach($menus as $m)
        @if($m->depth == 0)
            <li
                @foreach($menus->where('depth', 1)->where('parent', $m->id) as $subm)
                    @if($loop->first)
                        class="dropdown"
                    @endif
                @endforeach
            >
                <a href="{{ $m->link }}" 
                    @foreach($menus->where('depth', 1)->where('parent', $m->id) as $subm)
                        @if($loop->first)
                            class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        @endif
                    @endforeach
                >
                    {{ $m->label }}
                    @foreach($menus->where('depth', 1)->where('parent', $m->id) as $subm)
                        @if($loop->first)
                            <span class="caret"></span>
                        @endif
                    @endforeach
                </a>
                @foreach($menus->where('depth', 1)->where('parent', $m->id) as $subm)
                        @if($loop->first)
                            <ul class="dropdown-menu">
                        @endif
                                <li 
                                    @foreach($menus->where('depth', 2)->where('parent', $subm->id) as $subsubm)
                                        @if($loop->first)
                                            class="dropdown dropdown-submenu"
                                        @endif
                                    @endforeach
                                >
                                    <a href="{{ $subm->link }}"
                                        @foreach($menus->where('depth', 2)->where('parent', $subm->id) as $subsubm)
                                            @if($loop->first)
                                                class="dropdown-toggle" data-toggle="dropdown"
                                            @endif
                                        @endforeach
                                    >{{ $subm->label }}</a>
                                    @foreach($menus->where('depth', 2)->where('parent', $subm->id) as $subsubm)
                                        @if($loop->first)
                                            <ul class="dropdown-menu">
                                        @endif
                                            <li><a href="{{ $subsubm->link }}">{{ $subsubm->label }}</a></li>
                                        @if($loop->last)
                                            </ul>
                                        @endif
                                    @endforeach
                                </li>
                        @if($loop->last)
                            </ul>
                        @endif
                @endforeach
            </li>
        @endif
    @endforeach
</ul>
@endif