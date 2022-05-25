<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.name')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="{{config('app.url')}}"><b>{{config('app.name')}}</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Thank you for choosing our site</div><br>



  @guest
    <div class="text-center row">
        @if (Route::has('login'))
          <div class="col-sm-6">
            <a href="{{ route('login') }}" class="btn btn-outline-info btn-block btn-flat ">Login</a>
          </div>
        @endif

        @if (Route::has('register'))
            <div class="col-sm-6">
              <a href="{{ route('register') }}" class="btn btn-outline-info btn-block btn-flat ">Sign Up</a>
            </div>
        @endif
    </div>

  @else
  <div class="text-center row">
    <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <a href="{{ route('login') }}" class="btn btn-outline-info btn-block btn-flat " href="{{ route('logout') }}"
        onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
      </div>
    <div class="col-sm-4"></div>

  </div>

  @endguest


  <div class="lockscreen-footer text-center">
    Copyright &copy; 2021-{{ now()->year }} <b><a href="{{config('app.url')}}" class="text-black" target="_blank">{{config('app.name')}}</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
