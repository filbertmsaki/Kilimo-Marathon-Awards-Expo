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
        Award Nominee Registration | Kilimo Marathon, Awards & EXPO
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
                    <h2 style="color:#fff;">Award Nominee Registration</h2>
                </div>
                <div class="reg-instraction">
                    <h2>Please Note:</h2>
                    <div class="instraction-list">
                        <ul>
                            <li>TThe day of receipt the award will be 3<sup>rd</sup> September 2022 at SUA Ground.</li>
                            <li>Nomination Fee per category is FREE</li>
                            <li>After you fill the details , the form has to be submitted & then you will receive a
                                email with google form to fill up personal/company details</li>
                            <li>After nominee verification complete the voting window will be open, and you notified
                                through the emails.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>
        <section class="award-registration">
            <div class="container-fluid">
                <div class="row r-row">
                    <div class="col-md-12 col-sm-12 col-xs-12 r-col">
                        <h2 class="r-header">Registration Form
                        </h2>
                        <form class="shake contactForm" action="{{ route('awards_nominees_store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name" class="sr-only">Nominee Name / Company Name</label>
                                        <input type="text" placeholder="Enter Nominee Name / Company Name"
                                            id="full_name" class="form-control contact-control" name="full_name"
                                            required="" value="{{ old('full_name') }}">
                                        @if ($errors->has('full_name'))
                                        <span class="text-danger">{{ $errors->first('full_name') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="sr-only">Email</label>
                                        <input type="email" placeholder="Enter Your Email" id="email"
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
                                        <input type="mobile" pattern="^\d{1}\d{9}$"
                                            placeholder="Enter Mobile Number e.g: 0xxxxxxxxx"
                                            title=" Please match the required format 0xxxxxxxxx " id="mobile"
                                            class="form-control contact-control" name="mobile" required=""
                                            value="{{ old('mobile') }}">
                                        @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="sr-only">Address</label>
                                        <input type="text" placeholder="Address(Where do you live.?)" id="address"
                                            class="form-control contact-control" name="address" required=""
                                            value="{{ old('address') }}">
                                        @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="select-d30c" name="company_individual"
                                            class="form-control contact-control" required="">
                                            <option value="Individual">Individual</option>
                                            <option value="Company">Company</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="select-69e9" name="award_category"
                                            class="form-control contact-control required">
                                            <option value="">-- Choose Category --</option>

                                            @foreach ($award_category as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>

                                            @endforeach



                                        </select>
                                        @if ($errors->has('award_category'))
                                        <span class="text-danger">{{ $errors->first('award_category') }}</span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="submit-btn">
                                <button class="btn btn-common btn-lg " type="submit" name='submit' value="submit"
                                    style="pointer-events: all; cursor: pointer;"> Register <i
                                        class="fa fa-arrow-right"></i></button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </section>
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