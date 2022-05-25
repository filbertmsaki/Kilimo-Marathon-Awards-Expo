<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
                Kilimo Marathon, Awards & EXPO | Home Page
            </title>
        
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/bootstrap.min.css') }}">
    
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/slick.css') }}">
            
            <link rel="stylesheet" media="screen" href="{{ asset('asset/css/all.min.css') }}">
            <link rel="stylesheet" media="screen" href="{{ asset('asset/css/simple-line-icons.css') }}">
            
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/owl.carousel.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/owl.theme.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/animate.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/normalize.css') }}">
            
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/main.css') }}">
            
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/responsive.css') }}">
            
            <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/green.css" media="screen') }}">
        <style>
            .section1{
                background-color: #006837;
                color: #ffffff;
               
            }
            .inner-section{
                width: auto;
                margin: 0 0 0 auto;
                
                
        
            }
           
            
            .section1 .u-line-1 {
            width: 111px;
            height: 6px;
            transform-origin: left center 0px;
            margin: 38px auto 0 0;
            background-color: #fff;
            }
            .section1 .u-text-1 {
            font-size: 4.4375rem;
            font-weight: 700;
            line-height: 1;
            margin: 11px 0 0;
            color: #ffffff;
            }
            .u-text-2 {
            font-weight: 600;
            font-size: 1rem;
            font-style: normal;
            line-height: 1.2;
            margin: 14px 0 0;
            }
            .u-text-3{
                margin-left: 20px; ;
                margin-right: 20px;;
            }
            .btn-common1{
                pointer-events: all;
                cursor: pointer !important;
                opacity: 1 !important;
                color: #0f0e0e !important;
                background: #fdfdfd none repeat scroll 0 0;
                margin: 44px auto 0 0;
                padding: 10px 52px 10px 50px;
                
            }
            .section-cell{
                background-color: #fff;
                padding-bottom: 20px;
            }
            .img-fluid {
            margin: 81px auto 0;
            object-fit: cover;
            display: block;
            }
            .description .u-text-1{
                text-align: center;
                font-size: 3.1rem;
                padding-top: 20px;
            }
            .c-row{
                width: auto;
                margin: 20px 15px 0 15px;
            }
            .c-row-inner{
                color: #111111;
                
            }
            .inner-desc{
               
                background-color: #ffffff;
                padding: 15px;
                margin: 10px 0 10px 0;
        
            }
            .text-desc{
                text-align: center;
                font-size: 1rem;
                margin: 0 auto;
                font-weight: 100;
            }
            .list {
                display: flex;
                flex-wrap: wrap;
                }
            .list-item {
                display: flex;
                margin-bottom: 5px;
                }
           
           
           
           
        </style>
        </head>
<body>

@include('layouts.front_header')

<section class="contact-form-section section1">
    <div class="container-fluid " >
    <div class="row ">
    
    <div class="col-md-6 contact-info-section section-cell " style="background-image: url('imgs/sunny-meadow-landscape.jpg');background-size: cover;">
        <div class="row c-row list">
            @foreach ($award_category as  $category)
            <div class="col-lg-4 col-md-4 col-sm-4 col-6 c-row-inner list-item">
                <div class="inner-desc">
                <h4 class="text-desc"> {{ $category->name }}</h4>
                </div>
            </div>
        
            @endforeach
        
          

        </div>
    </div>
    <div class="col-md-6 col-md-offset-1 contact-form contact-info-section  section-inner">
    
        <div class="contact-widget description">
            <h3 class="u-text-1">Awards Categories
            </h3>
        
        </div>
     @if($nominee != null)
        <p class="u-text-3" style="text-align: center;">
          Welcome <span style="font-style: italic; font-weight:900;">{{ $nominee->full_name }} </span>  you are participating in the Kilimo Marathon award under  category of <span style="font-style: italic; font-weight:900;"> {{ $nominee->awardcategory->name }}</span>          </p>
            @else
          Welcome <span style="font-style: italic; font-weight:900;">{{ auth()->user()->name  }} </span> If you want to participate in Kilimo Awards feel free to choose the category you want to nominate</p>
            <a href="{{ route('awards_nominees') }}" class="btn btn-common btn-lg  btn-common1"  id="form-submit" > REGISTER as a nominee</a>

          @endif
        <a class="btn btn-common btn-lg  btn-common1"  href="{{ route('logout') }}"
      onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
          <p style="padding-bottom: 20px;"></p>

    
    </div>
    </div>
    </div>
    </section>

@include('layouts.front_footer')

    
<script src="asset/js/jquery-min.js"></script>
<script src="asset/js/popper.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
<script src="asset/js/jquery.mixitup.js"></script>
<script src="asset/js/smoothscroll.js"></script>
<script src="asset/js/wow.js"></script>
<script src="asset/js/owl.carousel.min.js"></script>
<script src="asset/js/waypoints.min.js"></script>
<script src="asset/js/jquery.counterup.min.js"></script>
<script src="asset/js/jquery.appear.js"></script>
<script src="asset/js/form-validator.min.js"></script>
<script src="asset/js/contact-form-script.min.js"></script>
<script src="asset/js/slick.min.js"></script>
<script src="asset/js/main.js"></script>
    

</body></html>