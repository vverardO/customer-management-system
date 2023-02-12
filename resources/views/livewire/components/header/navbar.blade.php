<div class="topnav">
    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                @foreach($menus as $menu)
                    @empty($menu['sub-menus'])
                    <li class="nav-item dropdown {{$menu['active']}}">
                        <a class="nav-link dropdown-toggle arrow-none {{$menu['active']}}" href="{{$menu['route']}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='{{$menu['icon']}}'></i>
                            <span data-key="t-people">{{$menu['title']}}</span>
                        </a>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none {{$menu['active']}}" href="#" role="button"
                            >
                            <i class="{{$menu['icon']}}"></i>
                            <span key="t-ui-elements">{{$menu['title']}}</span> 
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu"
                            aria-labelledby="topnav-uielement">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div>
                                        @foreach($menu['sub-menus'] as $subMenu)
                                            <a href="{{$subMenu['route']}}" class="dropdown-item {{$subMenu['active']}}" key="t-alerts">{{$subMenu['title']}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </nav>
</div>