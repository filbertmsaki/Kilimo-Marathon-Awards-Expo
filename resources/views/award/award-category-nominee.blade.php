<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    @if (config('app.icon') !== null)
    <link rel="icon" type="image/png" href="{{ asset('image').'/'.config('app.icon') }}" />
    @else
    <link rel="icon" type="image/png" href="{{ asset('img/fem-creation-icon.png') }}" />
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Awards Vote | Kilimo Marathon, Awards & EXPO
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
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/green.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/default.css') }}">

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <style>
        .container {
            position: relative;
        }

        .list {
            display: flex;
            flex-wrap: wrap;
        }

        .list-item {
            display: flex;
        }

        .image-background {
            background-image: url('../imgs/image1.jpg');
            background-size: cover;
            position: relative;
        }

        .image-background:before {
            background-color: rgb(0, 104, 55, 0.9);
            content: '';
            display: block;
            height: 100%;
            position: absolute;
            width: 100%;
        }

        .syotimer {
            text-align: center;
            margin: 30px auto 0;
            padding: 0 0 10px;
            justify-content: center;
            display: flex;
        }

        .syotimer-cell__value {
            color: #ffffff;
            height: 50px;
            line-height: 45px;
            margin: 0 0 5px;
            border-bottom: 1px solid #15472f;
            background-color: #15472f !important;
        }

        .syotimer-cell {
            display: inline-block;
            margin: 0 5px;
            width: 63px;
            border: 1px solid #15472f;
            background: transparent;
        }

        .info-box {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            border-radius: 0px;
            border: 3px solid #006837;
            background-color: #fff;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            width: 100%;
            position: relative;
        }

        .info-box .info-box-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.8;
            flex: 1;
            padding: 0 10px;
            overflow: hidden;
        }

        .info-box .info-box-content .info-box-header {
            text-align: center;
            font-weight: 700;
            color: #000;
        }

        .info-box .info-box-content .info-box-desc {
            text-align: center;
            font-weight: 400;
            color: #000;

        }

        .info-box .info-box-content .info-box-bar {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .info-box-social-media {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        div#social-links {
            margin-top: 0px;
            margin-right: auto;
            margin-bottom: -10px;
            margin-left: auto;
        }

        div#social-links ul li {
            display: inline-block;
        }

        div#social-links ul li a {
            padding-left: 5px;
            padding-right: 5px;
            /* border: 1px solid #ccc; */

            font-size: 25px;
            color: #222;
            /* background-color: #ccc; */
        }

        .fa:hover {
            opacity: 0.7;
        }

        .fa-facebook-f {
            /* background: #3B5998; */
            color: #3B5998;
        }

        .fa-whatsapp {
            /* background: #34bf49; */
            color: #128c7e;
        }

        .fa-twitter {
            /* background: #55ACEE; */
            color: #55ACEE;
        }

        .fa-google {
            background: #dd4b39;
            color: white;
        }

        .fa-linkedin-in {
            /* background: #ffffff; */
            /* padding:0px; */
            color: #007bb5;
        }

        .info-box-bar .info-box-bar-line {
            border-bottom: 4px solid #15472f;
            width: 100%;
            margin-left: 10px;
            margin-right: 10px;

        }

        .info-box .info-box-footer {
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-box-footer .small-box-footer {
            color: #fff !important;
            background-color: #15472f;
            border: 2px solid #15472f;
            padding: 5px;


        }

        .small-box-footer:hover {
            color: #fff !important;
            background-color: #006837;
            border: 2px solid #02361e;

        }
        .deadline-description {
            text-align: center;
            color: #ffffff;
        }

        /* // X-Small devices (portrait phones, less than 576px) */
        @media screen and (max-width: 575.98px) {}

        /* // Small devices (landscape phones, less than 768px) */
        @media (max-width: 767.98px) {
            .syotimer {
                margin-top: 1px;
            }

            .syotimer__body {
                display: flex;
            }

            .syotimer-cell__value {
                font-size: 20px;
                color: #ffffff;
                height: 40px;
                line-height: 39px;
                margin: 0 0 5px;
                border-bottom: 1px solid #15472f;
                background-color: #15472f !important;
            }

            .syotimer-cell {
                display: inline-block;
                margin: 0 5px;
                width: 59px;
                height: 71px;
                border: 1px solid #15472f;
                background: transparent;
            }

            .syotimer-cell__unit {
                font-size: 10px;
            }

            .info-box .info-box-content {
                line-height: 1.5;
            }


            .info-box .info-box-content .info-box-header {
                font-size: 12px;
                font-weight: 700;
            }

            .info-box .info-box-content .info-box-desc {
                font-size: 12px;
            }

            .info-box-footer .small-box-footer {
                font-size: 17px;
            }

            div#social-links ul li a {
                font-size: 18px;
            }

            div#social-links {

                margin-bottom: -5px;

            }
        }

        /* // Medium devices (tablets, less than 992px) */
        @media (max-width: 991.98px) {}

        /* // Large devices (desktops, less than 1200px) */
        @media (max-width: 1199.98px) {}

        /* // X-Large devices (large desktops, less than 1400px) */
        @media (max-width: 1399.98px) {}

    </style>
</head>

<body>

    @include('layouts.front_header')

    <section id="team" class="image-background">
        @if($award_nominees != null)
        <div class="container" style="min-height:300px;">
            <h1 class="section-title wow fadeInUpQuick animated" data-wow-delay=".5s" style="color:#fff;visibility: visible;-webkit-animation-delay: .5s; -moz-animation-delay: .5s; animation-delay: .5s;">
                <p style="color:#ffffff;">Awards Nominees Voting </p>

            </h1>
            @if($award_settings->vote == '1' )
            @if(date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime( $award_settings->vote_time_remain)))


        <div class="deadline-description">
            @if(date("Y-m-d H:i:s") > date("Y-m-d H:i:s", strtotime('-8 day', strtotime( $award_settings->vote_time_remain))))
            <p>Time remain for voting. </p>
            <div id="simple_timer"></div>
            <input type="hidden" id="timer_value" value="{{ $award_settings->vote_time_remain }}">
            <div id="simple_timer"></div>
            <input type="hidden" id="timer_value" value="{{ $award_settings->vote_time_remain }}">
            @endif
        </div>



        @endif
        @endif


        <!-- =========================================================== -->
        <div class="row list">
            @foreach ( $award_nominees as $nominee )

            <div class="col-md-3 col-sm-6 col-6 list-item ">
                <div class="info-box">

                    <div class="info-box-content">
                        <span class="info-box-header">{{ $nominee->full_name }}</span>
                        <span class="info-box-desc">{{ $nominee->awardcategory->name }}</span>
                        <div class="info-box-social-media">
                            {!! $share !!}
                        </div>
                        <div class="info-box-bar">
                            <div class="info-box-bar-line"></div>
                        </div>
                        <div class="info-box-footer">


                            <form class="small-box-form" id="vote_form_{{ $nominee->id }}" method="POST" action="{{ route('awards_vote_store') }}">
                                @csrf
                                <input type="hidden" name="nominee_id" value="{{ $nominee->id }}">

                                <input type="hidden" name="category_id" value="{{ $nominee->awardcategory->id }}">

                                <a href="{{ route('votes_nominees',$nominee->id) }}" class="small-box-footer" onclick="document.getElementById('vote_form_{{ $nominee->id }}').submit(); return false;">
                                    Vote <i class="fas fa-vote-yea"></i>
                                </a>

                            </form>
                        </div>
                        {{-- <center>
                  <a href="{{ route('awards_category_nominees',$category->slug) }}" class="small-box-footer"
                        style="color:#fff;">
                        Vote Now <i class="fas fa-arrow-circle-right"></i>
                        </a>
                        </center> --}}
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            @endforeach


        </div>
        <!-- /.row -->
        </div>
        @endif
    </section>




    @include('layouts.front_footer')

    <script src="{{ asset('asset/js/jquery-min.js') }}"></script>
    <script src="{{ asset('asset/js/popper.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.mixitup.js') }}"></script>
    <script src="{{ asset('asset/js/smoothscroll.js') }}"></script>
    <script src="{{ asset('asset/js/wow.js') }}"></script>
    <script src="{{ asset('asset/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('asset/js/form-validator.min.js') }}"></script>
    <script src="{{ asset('asset/js/contact-form-script.min.js') }}"></script>
    <script src="{{ asset('asset/js/slick.min.js') }}"></script>
    <script src="{{ asset('asset/js/main.js') }}"></script>
    <script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}"></script>

    <script src="{{ asset('asset/js/jquery.syotimer.js') }}"></script>


    <script type="text/javascript">
        $(function() {


            var timer_value = document.getElementById("timer_value").value;
            var date = new Date(timer_value);

            $('#simple_timer').syotimer({
                year: date.getFullYear()
                , month: date.getMonth() + 1
                , day: date.getDate()
                , hour: date.getHours()
                , minute: date.getMinutes()
                , seconds: date.getSeconds()
            });

        });

    </script>

</body>

</html>
