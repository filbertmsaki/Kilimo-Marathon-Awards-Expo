<x-web.layout.app-layout :isPagetitle="true" :pageTitle='"Contact Us"'>
    <section class="py-50">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-12">
                    <form class="contact-form" action="{{ route('web.contactUs.store') }}" method="POST">
                        @csrf
                        <div class="text-start mb-30">
                            <h2>Get In Touch</h2>
                            <p>We'd love to hear from you whether you are curious about our information, events and
                                servises</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                                        class="form-control" placeholder="First Name" required>
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                                        class="form-control" placeholder="Last Name" required>
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        class="form-control" placeholder="Phone" required>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control" placeholder="Your Email" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="message" value="{{ old('message') }}" rows="5" class="form-control" required
                                        placeholder="Message"></textarea>
                                    @if ($errors->has('message'))
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"> Send
                                    Message</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5 col-12 mt-30 mt-md-0">
                    <div class="box box-body p-40 bg-dark mb-0">
                        <h2 class="box-title text-white">Contact Info</h2>
                        <p>Interested in Kilimo Marathon, Awards and Expo , just pick up the phone or email and chat
                            with our agent</p>
                        <div class="widget fs-18 my-20 py-20 by-1 border-light">
                            <ul class="list list-unstyled text-white-80">
                                <li class="ps-40"><i class="ti-location-pin"></i>Shambadunia Limited,<br>
                                    Salum Abdalah Street, Block G, Plot No 10 (Halotel Building) Opposite Exim Bank. 1st Floor, Morogoro. Tanzania.
                                    </li>
                                <li class="ps-40 my-20"><i class="ti-location-arrow"></i>P.O Box 2380 Morogoro. Tanzania
                                </li>
                                <li class="ps-40 my-20"><i class="ti-mobile"></i>+255 754 222 800 | +255 766 300 777
                                </li>
                                <li class="ps-40"><i class="ti-email"></i>marketing@kilimomarathon.co.tz</li>
                            </ul>
                        </div>
                        <h4 class="mb-20">Follow Us</h4>
                        <ul class="list-unstyled d-flex gap-items-1">
                            <li><a href="https://www.facebook.com/kilimomarathonexpo" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-facebook"><i
                                        class="fa fa-facebook"></i></a></li>
                            <li><a href="https://twitter.com/kilimo_MAE" target="_blank"
                                    class="waves-effect waves-circle btn btn-social-icon btn-circle btn-twitter"><i
                                        class="fa fa-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/kilimo_marathon" target="_blank"
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
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1322.7990289354602!2d37.663525634847296!3d-6.8256944232534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185a5d3ff0760019%3A0x5942d18efc81b3f7!2sShambadunia%20Ltd!5e0!3m2!1sen!2stz!4v1719776837305!5m2!1sen!2stz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
