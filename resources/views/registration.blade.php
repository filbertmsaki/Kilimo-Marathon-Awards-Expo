<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="description"
        content="KILIMO MARATHON which will be a half-marathon with a theme for Agriculture sector in general for the aim of helping us realizing our main goal which is to reveal tangible support in Tanzania’s agricultural growth">
    <meta name="title" content="A chance to the Agriculture sector to grow and develop | Kilimo Marathon, Awards & EXPO">
    <meta name="medium" content="mult">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="twitter:card" content="summary_large_image">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="Kilimo, Marathon, Agriculture,Kimbilia Shambani,Expo">
    <meta name="author" content="Filbert Msaki - developer.filymsaki@gmail.com">
    <meta property="og:title" content="A chance to the Agriculture sector to grow and develop | Kilimo Marathon, Awards & EXPO">
    <meta property="og:url" content="https://kilimomarathon.co.tz/">
    <meta property="og:description"
        content="KILIMO MARATHON which will be a half-marathon with a theme for Agriculture sector in general for the aim of helping us realizing our main goal which is to reveal tangible support in Tanzania’s agricultural growth">
    <meta property="og:image" content="{{ asset('img/default-meta-image.png') }}">
    <meta property="og:type" content="marathon_agriculture_site">
    <meta property="og:site_name" content="Kilimo Marathon, Awards & EXPO">
    <meta property="og:locale" content="en_US">
    <meta name="twitter:domain" content="www.kilimomarathon.co.tz">
    <meta name="twitter:title"
        content="A chance to the Agriculture sector to grow and develop | Kilimo Marathon, Awards & EXPO">
    <meta name="twitter:url" content="https://kilimomarathon.co.tz/">
    <meta name="twitter:description"
        content="KILIMO MARATHON which will be a half-marathon with a theme for Agriculture sector in general for the aim of helping us realizing our main goal which is to reveal tangible support in Tanzania’s agricultural growth">
    <meta name="twitter:image" content="{{ asset('img/default-meta-image.png') }}">
    <meta name="twitter:site" content="@kilimo_MAE">
    <meta itemprop="name" content="A chance to the Agriculture sector to grow and develop | Kilimo Marathon, Awards & EXPO">
    <meta itemprop="url" content="https://kilimomarathon.co.tz/">
    <meta itemprop="description"
        content="To create an entertainment themed event for agriculture where people can meet and have fun while learning and observing the growth of the sector.">
    <meta itemprop="image" content="{{ asset('img/default-meta-image.png') }}">
    @if (config('app.icon') !== null)
    <link rel="icon" type="image/png" href="{{ asset('image').'/'.config('app.icon') }}" />
    @else
    <link rel="icon" type="image/png" href="{{ asset('img/fem-creation-icon.png') }}" />
    @endif

    <title>
        Registration | Kilimo Marathon, Awards & EXPO
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
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/style.css') }}">



</head>

<body>

    @include('layouts.front_header')
    <div class="image-background">
        <section class="contact-form-section">
            <div class="container reg-container">


                <div class="reg-header">
                    <h2>Kilimo Marathon Registration</h2>
                    {{-- <p>Fill the form in order to participate in the Kilimo Marathon this December 18<sup>th</sup>.
                        After submit the form you will be redirected to the payment page. The amount required for
                        marathon registration is 35,000 Tsh only for all categories</p> --}}
                </div>
                <div class="reg-instraction">
                    <h2>Please Note:</h2>
                    <div class="instraction-list">
                        <ul>
                            <li>The marathon date is 03<sup>rd</sup> September 2022 at SUA Ground.</li>
                            <li>Registration Fee per run distance is Tsh 35,000/- including T-Shirt & BIB number</li>
                            <li>After you fill the details , the form has to be submitted & then you will be lead to the
                                payment page</li>
                            <li>Or you can choose to pay the running fee using our LIPA NUMBER instead of registering in
                                the website</li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>
        @include('partials.marathon-registration-form')

    </div>



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





</body>

</html>