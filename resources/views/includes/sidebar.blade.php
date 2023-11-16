<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="/home" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img width="70px" src="{{asset('assets/images/quiz.png')}}" />
                </a>
        </div>
        <div class="navbar-content">
            <div class="card pc-user-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{asset('assets/images/user/avatar-1.jpg')}}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                        </div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small>{{ eKreative::myRoleName() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ route('home') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                              <use xlink:href="#custom-home"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Home</span>
                    </a>
                </li>
                @foreach (eKreative::sidebarMenu() as $menu)
                    <li class="pc-item">
                        <a class="pc-link" href="{{ !empty($menu->children) ? '#' : url($menu->url) }}">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                  <use xlink:href="#custom-box-1"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">{{ $menu->name }}</span>
                            @if (!empty($menu->children))
                                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                            @endif
                        </a>

                        @if (!empty($menu->children))
                            <ul class="pc-submenu">
                                @foreach ($menu->children as $child)
                                <li class="pc-item">
                                    <a class="pc-link" href="{{ url($child->url) }}">
                                        <span class="pc-mtext">{{ $child->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>

            <ul class="pc-navbar">
                @if (eKreative::myRoleName() == 'Super Admin')
                    <li class="pc-item pc-caption">
                        <label>Apps Manajemen</label>
                        <i class="ti ti-chart-arcs"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('users.index') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-user-square"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">User List</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('roles.index') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-flag"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Role List</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('menus.index') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-text-align-justify-center"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Menu List</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('actions.index') }}" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-story"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Action List</span>
                        </a>
                    </li>
                @endif
            </ul>
            {{-- <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    @foreach (eKreative::sidebarMenu() as $menu)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ !empty($menu->children) ? '#' : url($menu->url) }}">
                                <i class="nav-icon fas {{ $menu->icon }}"></i>
                                <p>{{ $menu->name }}</p>
                                @if (!empty($menu->children))
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </a>
                            @if (!empty($menu->children))
                                <ul class="nav nav-treeview">
                                    @foreach ($menu->children as $child)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url($child->url) }}">
                                                <i class="nav-icon fas {{ $child->icon }}"></i>
                                                <p>{{ $child->name }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav> --}}
        </div>
    </div>
</nav>
