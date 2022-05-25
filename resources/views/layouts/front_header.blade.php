<style>
    .btn-common{
        border-style: solid;border-color: rgb(255, 255, 255);
    }
    
    
  </style>
  <header id="header-wrap">
  
    <div class="header-navbar">
    <div class="navbar-area ">
    <div class="container">
    <div class="row">
    <div class="col-lg-12">
    <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="{{ route('index') }}">
    <img src="{{ asset('imgs/KILIMO-MARATHON--EXPO-LOGO.png') }}" width="100" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="toggler-icon"></span>
    <span class="toggler-icon"></span>
    <span class="toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
    <a href="{{ route('index') }}">Home</a>
    
    </li>
    <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
    <a href="{{ route('about') }}">About Us</a>
    
    </li>
    <li class="nav-item {{ Request::is('sponsorship') ? 'active' : '' }}">
    <a href="{{ route('sponsorship') }}">Sponsorship</a>
    
    </li>
    <li class="nav-item {{ Request::is('registration') ? 'active' : '' }}">
    <a href="{{ route('registration') }}">Register For Marathon</a>
     
    </li>
    <li class="nav-item {{ Request::is('awards') ? 'active' : '' }}">
    <a href="{{ route('awards') }}">Kilimo Award Registration</a>
    
    </li>
   
    @if($award_settings->vote == '1' )
    @if(date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime( $award_settings->vote_time_remain)))
        <li class="nav-item {{ Request::is('votes*') ? 'active' : '' }}">
          <a href="{{ route('votes') }}">Vote</a>
          
      </li>
      @endif
    @endif
   
        
    <li class="nav-item {{ Request::is('contact-us') ? 'active' : '' }}">
    <a href="{{ route('contact_us') }}">Contact Us</a>
    
    </li>
    {{-- <li class="nav-item dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="#">Start Learning</a></li>
        <li><a href="#">View All Courses</a></li>
        <li><a href="#">Chat with a CodeGuide</a></li>
      </ul>
    </li> --}}
    </ul>
    </div> 
    
    </nav> 
    </div>
    </div> 
    </div> 
    </div> 
    </div> 
    
  
  </header>

  <section class="content">
    <div class="container-fluid">
      @if(session('success'))
      <div class="alert alert-success alert-dismissible" id="success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <strong></strong> {{ session('success') }}.
        </div>
      @endif
      @if(session('danger'))
      <div class="alert alert-danger alert-dismissible" id="danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <strong></strong> {{ session('danger') }}.
        </div>
      @endif
      @if(session('warning'))
      <div class="alert alert-warning alert-dismissible" id="warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <strong></strong> {{ session('warning') }}.
        </div>
      @endif
      @if(session('vote'))
      <div class="alert alert-warning alert-dismissible" id="warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <strong></strong> {{ session('vote') }}.
        </div>
      @endif
    </div>
  </section>
  @if($errors->any())
  
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
      <strong>Sory !.</strong> {{ $errors->first() }}.
  </div>
  @endif
  