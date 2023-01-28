<div class="topnav">
    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                @foreach($menus as $menu)
                    <li class="nav-item dropdown {{$menu['active']}}">
                        <a class="nav-link dropdown-toggle arrow-none {{$menu['active']}}" href="{{$menu['route']}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='{{$menu['icon']}}'></i>
                            <span data-key="t-people">{{$menu['title']}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</div>