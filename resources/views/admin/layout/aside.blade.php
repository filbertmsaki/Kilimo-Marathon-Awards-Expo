<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('admin.index') }}" class="brand-link">
    @if (config('app.logo') !== null)
    <img src="{{ asset('image').'/'.config('app.logo') }}" alt="{{config('app.name') }} Logo"
      class="brand-image img-circle elevation-3" style="opacity: .9">
    @else
    <img src="{{ asset('imgs/fem-creation.png') }}" alt="{{config('app.name') }} Logo"
      class="brand-image img-circle elevation-3" style="opacity: .9">

    @endif
    <span class="brand-text font-weight-light" style="font-size: 90%;">{{config('app.name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">

        @if( is_null(auth()->user()->photo))
        <img src="{{ asset('imgs/avatar.png') }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">

        @else
        <img src="{{ asset('image').'/'.auth()->user()->photo }}" class="img-circle elevation-2"
          alt="{{ auth()->user()->name }}">
        @endif
      </div>
      <div class="info">
        @if (auth()->user()->first_name || auth()->user()->last_name)
        <a href="{{ route('admin.profile') }}" class="d-block">{{ auth()->user()->first_name .'
          '.auth()->user()->last_name }}</a>
        @else
        <a href="{{ route('admin.profile') }}" class="d-block">{{ auth()->user()->name }}</a>

        @endif
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="{{ route('admin.index') }}" class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>


        <li class="nav-item {{ Request::is('admin/marathon*') ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-running"></i>
            <p>
              Marathon
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.marathon_runners') }}"
                class="nav-link {{ Request::is('admin/marathon/runners*') ? 'active' : '' }}">
                <i class="fa fa-running nav-icon"></i>
                <p>Marathon Runners</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.marathon_settings') }}"
                class="nav-link {{ Request::is('admin/marathon/settings*') ? 'active' : '' }}">
                <i class="fa fa-cog nav-icon"></i>
                <p>Marathon Settings</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item {{ Request::is('admin/awards*') ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-medal"></i>
            <p>
              Award
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.award_category') }}"
                class="nav-link {{ Request::is('admin/awards/category*') ? 'active' : '' }}">
                <i class="fas fa-award nav-icon"></i>
                <p>Award Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.award_nominee') }}"
                class="nav-link {{ Request::is('admin/awards/nominee*') ? 'active' : '' }}">
                <i class="fas fa-book-reader nav-icon"></i>
                <p>Award Nominee</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('admin.award_settings') }}"
                class="nav-link {{ Request::is('admin/awards/settings*') ? 'active' : '' }}">
                <i class="fas fa-cog nav-icon"></i>
                <p>Award Settings</p>
              </a>
            </li>


          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.gallery') }}" class="nav-link {{ Request::is('admin/gallery*') ? 'active' : '' }}">
            <i class="fas fa-images nav-icon"></i>
            <p>Gallery</p>
            <span class="badge bg-primary float-right">@if($unread_message->count())<span class="badge badge-success">{{
                $unread_message->count() }} New</span>@endif</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.messages.index') }}"
            class="nav-link {{ Request::is('admin/messages*') ? 'active' : '' }}">
            <i class="fas fa-comments nav-icon"></i>
            <p>Messages</p>
            <span class="badge bg-primary float-right">@if($unread_message->count())<span class="badge badge-success">{{
                $unread_message->count() }} New</span>@endif</span>
          </a>
        </li>


        @role('admin')
        <li class="nav-item">
          <a href="{{ route('admin.dpo_payments.index') }}"
            class="nav-link {{ Request::is('admin/payments/dpo*') ? 'active' : '' }}">
            <i class="fas fa-money-bill-wave nav-icon"></i>
            <p>Payment</p>
          </a>
        </li>
        @endrole
        <li class="nav-item">
          <a href="{{ route('admin.subscribers') }}"
            class="nav-link {{ Request::is('admin/subscribers*') ? 'active' : '' }}">
            <i class="fas fa-bell nav-icon"></i>
            <p>Subscribers</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.contact_us') }}"
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
              <a href="{{ route('admin.user_index') }}"
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
        <li class="nav-item {{ Request::is('admin/settings*') ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              General Settings
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.site_settings_index') }}"
                class="nav-link {{ Request::is('admin/settings/site-settings*') ? 'active' : '' }}">
                <i class="fas fa-cog nav-icon"></i>
                <p>Site Settings</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.payments_settings.index') }}"
                class="nav-link {{ Request::is('admin/settings/payments*') ? 'active' : '' }}">
                <i class="fas fa-coins nav-icon"></i>
                <p>Payment Settings</p>
              </a>
            </li>


          </ul>
        </li>
        @endrole

        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
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