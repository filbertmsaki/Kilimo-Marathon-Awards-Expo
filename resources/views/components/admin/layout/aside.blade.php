<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard.index') }}" class="brand-link">
        @if (config('app.logo') !== null)
            <img src="{{ asset( config('app.logo')) }}" alt="{{ config('app.name') }} Logo"
                class="brand-image img-circle elevation-3" style="opacity: .9">
        @else
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo"
                class="brand-image img-circle elevation-3" style="opacity: .9">
        @endif
        <span class="brand-text font-weight-light" style="font-size: 90%;">{{ config('app.name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (is_null(auth()->user()->photo))
                    <img src="{{ asset('imgs/avatar.png') }}" class="img-circle elevation-2"
                        alt="{{ auth()->user()->name }}">
                @else
                    <img src="{{ asset('image') . '/' . auth()->user()->photo }}" class="img-circle elevation-2"
                        alt="{{ auth()->user()->name }}">
                @endif
            </div>
            <div class="info">
                @if (auth()->user()->first_name || auth()->user()->last_name)
                    <a href="{{ route('admin.user.profile.index') }}"
                        class="d-block">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
                @else
                    <a href="{{ route('admin.user.profile.index') }}" class="d-block">{{ auth()->user()->name }}</a>
                @endif
            </div>
        </div>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.index') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.award.*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->routeIs('admin.award.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-medal"></i>
                        <p>
                            Kilimo Awards
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.award.category.index') }}"
                                class="nav-link {{ request()->routeIs('admin.award.category.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Award Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.award.index') }}"
                                class="nav-link {{ request()->routeIs('admin.award.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Award Nominee</p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('admin.award.show*') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="javascript:void(0)"
                                class="nav-link {{ request()->routeIs('admin.award.show*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Nominees List Per Year
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach (award_years() as $item)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.award.show', $item->year) }}"
                                            class="nav-link {{ Request::is('admin/award/' . $item->year) ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>{{ $item->year }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.award.setting.index') }}"
                                class="nav-link {{ request()->routeIs('admin.award.setting.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Award Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.marathon.*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->routeIs('admin.marathon.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-running"></i>
                        <p>
                            Kilimo Marathon
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.marathon.index') }}"
                                class="nav-link {{ request()->routeIs('admin.marathon.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Runners List</p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('admin.marathon.runners*') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="javascript:void(0)"
                                class="nav-link {{ request()->routeIs('admin.marathon.runners*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Runner List Per Year
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach (marathon_years() as $item)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.marathon.runners', $item->year) }}"
                                            class="nav-link {{ Request::is('admin/marathon/runners/' . $item->year) ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>{{ $item->year }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.marathon.setting.index') }}"
                                class="nav-link {{ request()->routeIs('admin.marathon.setting.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Marathon Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.expo.*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="javascript:void(0)"
                        class="nav-link {{ request()->routeIs('admin.expo.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-campground"></i>
                        <p>
                            Kilimo Expo
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.expo.index') }}"
                                class="nav-link {{ request()->routeIs('admin.expo.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expo List</p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('admin.expo.show*') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="javascript:void(0)"
                                class="nav-link {{ request()->routeIs('admin.expo.show*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Expo List Per Year
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach (expo_years() as $item)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.expo.show', $item->year) }}"
                                            class="nav-link {{ Request::is('admin/expo/' . $item->year) ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>{{ $item->year }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.expo.setting.index') }}"
                                class="nav-link {{ request()->routeIs('admin.expo.setting.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expo Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.gallery.index') }}"
                        class="nav-link {{ Request::is('admin/gallery*') ? 'active' : '' }}">
                        <i class="fas fa-images nav-icon"></i>
                        <p>Gallery</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.partner.index') }}"
                        class="nav-link {{ Request::is('admin/partner*') ? 'active' : '' }}">
                        <i class="fas fa-handshake nav-icon"></i>
                        <p>Partner</p>
                    </a>
                </li>
                @role('admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.payment.flutterwave.index') }}"
                            class="nav-link {{ Request::is('admin/payments/flutterwave*') ? 'active' : '' }}">
                            <i class="fas fa-coins nav-icon"></i>
                            <p>Payment</p>
                        </a>
                    </li>
                @endrole
                <li class="nav-item">
                    <a href="{{ route('admin.subscribe.index') }}"
                        class="nav-link {{ Request::is('admin/subscribers*') ? 'active' : '' }}">
                        <i class="fas fa-bell nav-icon"></i>
                        <p>Subscribers</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.contact.index') }}"
                        class="nav-link {{ Request::is('admin/contact-us*') ? 'active' : '' }}">
                        <i class="fas fa-address-book nav-icon"></i>
                        <p>Contact Us</p>
                    </a>
                </li>
                @role('admin')
                    <li class="nav-item {{ Request::is('admin/account*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Users Setting
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('access-users')
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="nav-link {{ Request::is('admin/account/users*') ? 'active' : '' }}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            @endcan
                            @can('access-roles')
                                <li class="nav-item">
                                    <a href="{{ route('admin.role_index') }}"
                                        class="nav-link {{ Request::is('admin/account/role*') ? 'active' : '' }}">
                                        <i class="fas fa-user-check nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            @endcan
                            @can('access-permissions')
                                <li class="nav-item">
                                    <a href="{{ route('admin.permission_index') }}"
                                        class="nav-link {{ Request::is('admin/account/permissions*') ? 'active' : '' }}">
                                        <i class="fas fa-user-lock nav-icon"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endrole
                @role('admin')
                    <li class="nav-item {{ request()->routeIs('admin.setting.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                General Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.setting.site.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.setting.site.*') ? 'active' : '' }}">
                                    <i class="fas fa-cog nav-icon"></i>
                                    <p>Site Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.setting.payment.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.setting.payment.*') ? 'active' : '' }}">
                                    <i class="fas fa-coins nav-icon"></i>
                                    <p>Payment Settings</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
