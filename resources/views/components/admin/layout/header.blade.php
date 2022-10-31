<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                    class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard.index') }}" class="nav-link">Home</a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user.profile.index') }}" role="button">
                <i class="fas fa-user"></i>
            </a>
        </li>
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">
                    @if ($unread_messages->count())
                        {{ $unread_messages->count() }}
                    @endif
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($unread_messages as $thread)
                    <a href="{{ route('admin.messages.show', $thread->id) }}" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            @if ($thread->creator()->profile->first())
                                <img src="{{ asset('image') . '/' . $thread->creator()->profile->first()->photo }}"
                                    alt=" {{ $thread->creator()->name }}" class="img-size-50 img-circle mr-3">
                            @else
                                <img src="{{ asset('img/avatar.png') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                            @endif
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ $thread->creator()->name }}
                                </h3>
                                <p class="text-sm">{{ Str::limit($thread->subject, 25) }} </p>
                                <p class="text-sm text-muted"><i
                                        class="far fa-clock mr-1"></i>{{ $thread->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
                <a href="{{ route('admin.messages.index') }}" class="dropdown-item dropdown-footer">See All
                    Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">
                    @if ($unread_messages->count())
                        {{ $unread_messages->count() }}
                    @endif
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    @if ($unread_messages->count())
                        {{ $unread_messages->count() }} Notifications
                    @endif
                </span>
                @if ($unread_messages->count())
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.messages.index') }}" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> {{ $unread_messages->count() }} new messages
                        <span class="float-right text-muted text-sm">
                            {{ $unread_messages->first()->updated_at->diffForHumans() }} </span>
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
