<footer class="footer_three" data-aos="fade-up">
    <div class="footer-top bg-dark3 pt-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="widget">
                        <h4 class="footer-title">About</h4>
                        <hr class="bg-primary mb-10 mt-0 d-inline-block mx-auto w-60">
                        <p class="text-capitalize mb-20">SHAMBA DUNIA represents KILIMO MARATHON which will be a fun run
                            that will theme the Agriculture sector in general for the aim of helping us realizing our
                            main goal which reveals tangible support in Tanzania’s agricultural growth by realizing an
                            increase in investments and sales of agricultural products.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="widget">
                        <h4 class="footer-title">Contact Info</h4>
                        <hr class="bg-primary mb-10 mt-0 d-inline-block mx-auto w-60">
                        <ul class="list list-unstyled mb-30">
                            <li> <i class="fa fa-map-marker"></i>  429 Mahando Road, Masaki Dar es salaam,Tanzania
                            </li>
                            <li> <i class="fa fa-phone"></i> <span>+(255) 754 222 800  </span></li>
                            <li> <i class="fa fa-envelope"></i><span>marketing@kilimomarathon.co.tz </span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-lg-3" >
                    <div class="widget footer_widget">
                        <h4 class="footer-title">Quick Link</h4>
                        <hr class="bg-primary mb-4 mt-0 d-inline-block mx-auto w-60">
                        <ul class="list list-arrow">
                            <li><a href="{{ route('web.refund.policy') }}">Refund Policy</a></li>
                            <li><a href="https://shambadunia.com" target="_blank">Shambadunia</a></li>
                            <li><a href="{{ route('web.contactUs') }}">Contact Us</a></li>
                            <li><a href="#">FAQs</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="widget">
                        <h4 class="footer-title mt-20">Newsletter</h4>
                        <hr class="bg-primary mb-4 mt-0 d-inline-block mx-auto w-60">
                        <div class="mb-20">
                            <form class="" action="{{ route('web.subscribe') }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input name="email" required="required" class="form-control"
                                        placeholder="Your Email Address" type="email">

                                    <button type="submit" class="btn btn-primary"> <i
                                            class="fa fa-envelope"></i> </button>
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-dark3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-12 text-md-start text-center"> © 2021 - {{ date('Y') }} <span
                        class="text-white">KMAE</span> All Rights Reserved.</div>
                <div class="col-md-6 mt-md-0 mt-20">
                    <div class="social-icons">
                        <ul class="list-unstyled d-flex gap-items-1 justify-content-md-end justify-content-center">
                            <li><a href="https://www.facebook.com/kilimomarathonexpo" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-facebook"><i
                                        class="fa fa-facebook"></i></a></li>
                            <li><a href="https://twitter.com/kilimo_MAE" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-twitter"><i
                                        class="fa fa-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/kilimomarathon/" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-instagram"><i
                                        class="fa fa-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/kilimo-marathon-a3a70b225/" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-linkedin"><i
                                        class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
