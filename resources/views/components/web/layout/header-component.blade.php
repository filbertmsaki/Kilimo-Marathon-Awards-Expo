<header class="top-bar text-dark">
    <div class="topbar">

        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-6 col-12 d-lg-block d-none">
                    <div class="topbar-social text-center text-md-start topbar-left">
                        <ul class="list-inline d-md-flex d-inline-block">

                            <li class="ms-10 pe-10"><a href="#"><i class="text-dark fa fa-envelope"></i>
                                    marketing@kilimomarathon.co.tz</a></li>
                            <li class="ms-10 pe-10"><a href="#"><i class="text-dark fa fa-phone"></i>+(255) 754 222 800 </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-12 xs-mb-10">
                    <div class="topbar-call text-center text-lg-end topbar-right">
                        <ul class="list-inline d-lg-flex justify-content-end">

                            @if (auth()->check())
                                <li class="me-10 ps-10"><a href="#"><i
                                            class="text-dark fa fa-dashboard d-md-inline-block d-none"></i> My
                                        Account</a></li>
                                <li class="me-10 ps-10"><a href="#"><i
                                            class="text-dark fa fa-sign-in d-md-inline-block d-none"></i> Logout</a>
                                </li>
                            @else
                                <li class="me-10 ps-10"><a href="#"><i
                                            class="text-dark fa fa-user d-md-inline-block d-none"></i> Register</a></li>
                                <li class="me-10 ps-10"><a href="#"><i
                                            class="text-dark fa fa-sign-in d-md-inline-block d-none"></i> Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav hidden class="nav-dark nav-white">
        <div class="nav-header ">
            <a href="{{ route('web.index') }}" class="brand py-0 " style="width:80px; height:auto;">
                <img width="70" src="{{ asset('logo.png') }}" alt="" />
            </a>
            <button class="toggle-bar">
                <span class="ti-menu"></span>
            </button>
        </div>
        <ul class="menu">
            <li class=" {{ request()->routeIs('web.index') ? 'active' : '' }}">
                <a href="{{ route('web.index') }}">Home</a>
            </li>
            <li class=" {{ request()->routeIs('web.aboutUs') ? 'active' : '' }}">
                <a href="{{ route('web.aboutUs') }}">About</a>
            </li>

            <li class=" {{ request()->routeIs('web.sponsorship') ? 'active' : '' }}">
                <a href="{{ route('web.sponsorship') }}">Sponsorship</a>
            </li>
            <li class="dropdown {{ request()->routeIs('web.event.*') ? 'active' : '' }}">
                <a href="#">Events</a>
                <ul class="dropdown-menu">
                    <li class=" {{ request()->routeIs('web.event.award.*') ? 'active' : '' }}"><a
                            href="{{ route('web.event.award.index') }}">Kilimo Award</a></li>
                    <li class=" {{ request()->routeIs('web.event.expo.*') ? 'active' : '' }}"><a
                            href="{{ route('web.event.expo.index') }}">Kilimo Expo</a></li>
                    <li class=" {{ request()->routeIs('web.event.marathon.*') ? 'active' : '' }}"><a
                            href="{{ route('web.event.marathon.index') }}">Kilimo Marathon</a></li>
                </ul>
            </li>
            <li class=" {{ request()->routeIs('web.gallery') ? 'active' : '' }}">
                <a href="{{ route('web.gallery') }}">Gallery</a>
            </li>
            @if (isVoteActive())
                <li class=" {{ request()->routeIs('web.event.vote.*') ? 'active' : '' }}">
                    <a href="{{ route('web.event.vote.index') }}">Voting</a>
                </li>
            @endif
            <li class=" {{ request()->routeIs('web.contactUs') ? 'active' : '' }}">
                <a href="{{ route('web.contactUs') }}">Contact Us</a>
            </li>
        </ul>
        @if (isMarathonActive())
            <ul class="attributes">
                <li class="d-md-block d-none">
                    <a href="{{ route('web.event.marathon.registration') }}" class="px-10 pt-15 pb-10">
                        <div class="btn btn-primary py-5">Marathon Registration</div>
                    </a>
                </li>
            </ul>
        @endif
    </nav>
</header>
