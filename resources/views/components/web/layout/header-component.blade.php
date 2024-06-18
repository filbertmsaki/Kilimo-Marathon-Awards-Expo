<header class="top-bar text-dark">
    <div class="topbar">

        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-6 col-12 d-lg-block d-none">
                    <div class="topbar-social text-center text-md-start topbar-left">
                        <ul class="list-inline d-md-flex d-inline-block">

                            <li class="ms-10 pe-10"><a href="#"><i class="text-dark fa fa-envelope"></i>
                                    marketing@kilimomarathon.co.tz</a></li>
                            <li class="ms-10 pe-10"><a href="#"><i class="text-dark fa fa-phone"></i>+255 754 222
                                    800 | +255 766 300 777 </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-12 xs-mb-10">
                    <div class="topbar-call text-center text-lg-end topbar-right">
                        <ul class="list-unstyled d-flex  justify-content-md-end justify-content-center">
                            <li><a href="https://www.facebook.com/kilimomarathonexpo" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-facebook"><i
                                        class="fa fa-facebook"></i></a></li>
                            <li><a href="https://twitter.com/kilimo_MAE" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-twitter"><i
                                        class="fa fa-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/kilimomarathon/" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-instagram"><i
                                        class="fa fa-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/kilimo-marathon-a3a70b225/" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-linkedin"><i
                                        class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav hidden class="nav-dark nav-white">
        <div class="nav-header ">
            <a href="{{ route('web.index') }}" class="brand py-0 " style="width:180px; height:auto; padding:10px">
                <img width="200" src="{{ asset('logo.png') }}" alt="" />
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
                    <li class=" {{ request()->routeIs('web.event.marathon.*') ? 'active' : '' }}"><a
                            href="{{ route('web.event.marathon.index') }}">Marathon, Cycling</a></li>
                    <li class=" {{ request()->routeIs('web.event.expo.*') ? 'active' : '' }}"><a
                            href="{{ route('web.event.expo.index') }}">Agribusiness Exhibition</a></li>
                    <li class=" {{ request()->routeIs('web.event.award.*') ? 'active' : '' }}"><a
                            href="{{ route('web.event.award.index') }}">Awards and Panel Discussions</a></li>
                    <li class=" {{ request()->routeIs('web.event.agri-tourism.*') ? 'active' : '' }}"><a
                            href="{{ route('web.event.agri-tourism.index') }}"> Agri-Tourism </a></li>
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
