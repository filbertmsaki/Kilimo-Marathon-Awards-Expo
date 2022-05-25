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
        Order | Kilimo Marathon, Awards & EXPO
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

</head>

<body>

    @include('layouts.front_header')


    <section class="contact-form-section " style="padding-bottom: 50px; background-color: #006837; color:#fff;">
        <div class="container">
            <div class="row">
                @if(session('data'))
                @foreach(session('data') as $id => $details)
                <div class="col-md-12 mb-50 text-center contact-title-text wow fadeIn animated" data-wow-delay="0.3s"
                    style="visibility: visible;-webkit-animation-delay: 0.3s; -moz-animation-delay: 0.3s; animation-delay: 0.3s;">
                    <h2 style="color:#ffffff;">Kilimo Marathon Package Payment</h2>

                    <p>Fill the form below to continue to pay for <strong> {{ $details['package'] }}</strong> amount {{
                        number_format($details['amount']) }} /=</p>








                </div>

                <div class="col contact-form contact-info-section">
                    <form class="shake contactForm" action="{{ route('package_payment') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="description" value="{{ $details['package'] }}">
                        <input type="hidden" name="amount" value="{{  $details['amount']}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="sr-only">First Name</label>
                                    <input type="text" placeholder="First Name" id="first_name"
                                        class="form-control contact-control" name="first_name" required=""
                                        value="{{ old('first_name') }}">
                                    @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="last_name" class="sr-only">Last Name</label>
                                    <input type="text" placeholder="Last Name" id="last_name"
                                        class="form-control contact-control" name="last_name"
                                        value="{{ old('last_name') }}">
                                    @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" placeholder="Your Email" id="email"
                                        class="form-control contact-control" name="email" required=""
                                        value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile" class="sr-only">Mobile</label>
                                    <input type="tel"
                                        pattern="\+?\d{0,3}[\s\(\-]?([0-9]{2,3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})"
                                        placeholder="Enter your phone (e.g: +255**********)" id="mobile"
                                        class="form-control contact-control" name="mobile" required=""
                                        value="{{ old('mobile') }}">
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city" class="sr-only">city</label>
                                    <input type="text" placeholder="Your City" id="city"
                                        class="form-control contact-control" name="city" value="{{ old('city') }}">
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="sr-only">Address</label>
                                    <input type="text" placeholder="Address(Where do you live.?)" id="address"
                                        class="form-control contact-control" name="address"
                                        value="{{ old('address') }}">
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-common btn-lg " type="submit"
                            style="pointer-events: all; cursor: pointer;"><i class="fa fa-shopping-cart"></i> Complete
                            Order</button>

                    </form>
                </div>
                @endforeach
                @endif
            </div>
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


</body>

</html>