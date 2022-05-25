<footer>

    <div class="container">

        <div class="row section">

            <div class="footer-widget col-md-6 col-lg-4 col-xs-12">
                <h3 class="small-title">
                    About Us
                </h3>
                <p>
                    SHAMBA DUNIA represents KILIMO MARATHON which will be a fun run that will theme the Agriculture
                    sector in general for the aim of helping us realizing our main goal which reveals tangible support
                    in Tanzania’s agricultural growth by realizing an increase in investments and sales of agricultural
                    products.
                </p>

            </div>

            <div class="footer-widget col-md-6 col-lg-2 col-xs-12">
                <h3 class="small-title">
                    Quick Links
                </h3>
                <style>
                    footer .menu li {
                        float: left;
                        width: 100%;
                        padding-bottom: 10px;
                    }

                    .section {
                        padding: 50px 0 0 0;
                    }
                </style>
                <ul class="menu">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('awards') }}">Kilimo Awards</a></li>
                    <li><a href="{{ route('contact_us') }}">Contact Us for More Info</a></li>
                    <li><a href="{{ route('refund_policy') }}">Refund Policy</a></li>
                </ul>
            </div>


            <div class="footer-widget col-md-6 col-lg-3 col-xs-12">
                <h3 class="small-title">
                    Address Location
                </h3>
                <ul class="mb-3">
                    <li><i class="fa fa-map-marker-alt"></i> 429 Mahando Road, Masaki Dar es salaam
                    </li>
                    <li><i class="fa fa-phone"></i> +255 754 222 800 | +255 624 222 211</li>
                    <li><i class="fa fa-envelope"></i> marketing@kilimomarathon.co.tz</li>
                </ul>
            </div>


            <div class="footer-widget col-md-6 col-lg-3 col-xs-12">
                <h3 class="small-title">
                    Subscribe to our Newsletter
                </h3>
                <form method="POST" action="{{ route('subscribe') }}">
                    @csrf
                    <input type="text" name="email" placeholder="Email here">
                    @if ($errors ->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </form>

            </div>
        </div>
    </div>

    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <p class="copyright-text">Designed and Developed by <a href="https://ric.co.tz/"
                            rel="nofollow">RIC</a></p>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="social-footer text-right">
                        <a href="https://web.facebook.com/kilimomarathonexpo/" target="_blank"><i
                                class="fab fa-facebook-f icon-round icon-xs"></i></a>
                        <a href="https://twitter.com/kilimo_MAE" target="_blank"><i
                                class="fab fa-twitter icon-round icon-xs"></i></a>
                        <a href="https://instagram.com/kilimomarathon/" target="_blank"><i
                                class="fab fa-instagram icon-round icon-xs"></i></a>
                        <a href="https://linkedin.com/in/kilimo-marathon-a3a70b225/" target="_blank"><i
                                class="fab fa-linkedin icon-round icon-xs"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a href="#" class="back-to-top" style="display: none;">
    <i class="fa fa-angle-up">
    </i>
</a>

<div id="preloader" style="display: none;">
    <div class="loader" id="loader-1"></div>
</div>