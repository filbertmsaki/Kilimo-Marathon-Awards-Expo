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
        Awards Category List | Kilimo Marathon, Awards & EXPO
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

        .award-section {
          padding-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #fff;
        }

        .award-section .award-title {
            font-family: poppins, sans-serif;
            font-weight: 900;
            font-size: 34px;
            text-align: center;
            margin-bottom: 15px;
            text-transform: uppercase;
            line-height: 1.15;
        }

        .award-section .award-description {
            width: 70%;
            text-align: center;
            font-weight: 200;
            font-size: 18px;
        }

        .deadline-description {
            text-align: center;
            color: #ffffff;
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
        }

        .info-box .info-box-content .info-box-desc {
            text-align: center;
            font-weight: 400;
            font-size: 13px;
        }

        .info-box .info-box-content .info-box-bar {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .info-box-bar .info-box-bar-line {
            border: 2px solid #15472f;
            width: 100%;
            margin-left: 10px;
            margin-right: 10px;

        }

        .info-box-footer {
            margin-top: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .info-box-footer .small-box-footer {
            color: #fff !important;
            background-color: #15472f;
            border: 2px solid #ffffff;
            padding: 7px;


        }

        .small-box-footer:hover {
            color: #fff !important;
            background-color: #006837;
            border: 2px solid #02361e;



        }

        /* // X-Small devices (portrait phones, less than 576px) */
        @media screen and (max-width: 575.98px) {}

        /* // Small devices (landscape phones, less than 768px) */
        @media (max-width: 767.98px) {
            .award-section {
                margin-left: 10px;
                margin-right: 10px;
            }

            .award-section .award-title {

                font-size: 24px;
            }

            .award-section .award-description {
                width: 100%;
                font-weight: normal;
                font-size: 14px;

            }

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
                font-size: 13px;
                font-weight: 700;
            }

            .info-box .info-box-content .info-box-desc {
                font-size: 11px;
            }

            .info-box-footer .small-box-footer {
                font-size: 15px;


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

        <div class="container" style="min-height:300px;">
            <div class="award-section">
                <div class="award-title">
                    <span>Thank you for participate in kilimo marathon voting period </span>
                </div>
                <div class="award-description">
                    <p>
                      We're warm welcome you to participate in our marathon which will take place in SUA Ground on 30<sup>th</sup> October 
                    </p>
                </div>

            </div>
     
                <!-- =========================================================== -->
               
                <!-- /.row -->
        </div>

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



</body>

</html>