@php($title = 'Home PAge')
<x-web.layout.app-layout :isPagetitle="false" :pageTitle="$title">
    @section('css')
        <style>
        </style>
    @endsection
    <x-web.home.home-slider-component />
    <section class="py-xl-100 py-20 bg-white" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box box-body p-xl-50 p-10 bg-lightest">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-12">
                                <h1 class="mb-15">About KMAE</h1>
                                <p class="fs-22">KILIMO MARATHON which will be a half-marathon with a theme for
                                    Agriculture sector in general for the aim of helping us realizing our main goal
                                    which is to reveal tangible support in Tanzania’s agricultural growth by realizing
                                    an increase in investments and sales of agricultural products.</p>
                                <a href="{{ route('web.aboutUs') }}" class="btn  btn-primary">Read More</a>
                            </div>
                            <div class="col-lg-6 col-12 position-relative">
                                <div class="media-list media-list-hover media-list-divided md-post mt-lg-0 mt-30">
                                    <div class="media media-single box-shadowed bg-white pull-up mb-15"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary  text-overflow-h nowrap">Objective
                                            </h5>
                                            <p> To create an entertainment themed event for agriculture where people can
                                                meet and have fun while learning and observing the growth of the sector.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="media media-single box-shadowed bg-white pull-up mb-15"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary  text-overflow-h nowrap">Tagline
                                            </h5>
                                            <p>The marathon will accommodate audience of different age but all people
                                                from the family level can participate. We are hoping to host not less
                                                than 300.</p>
                                        </div>
                                    </div>
                                    <div class="media media-single box-shadowed bg-white pull-up mb-15"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary  text-overflow-h nowrap">Target
                                                Audience
                                            </h5>
                                            <p>Kilimo Marathon will go with a tag “ANZIA SHAMBANI” therefore it will
                                                rhyme KILIMO MARATHON ANZIA SHAMBANI.</p>
                                        </div>
                                    </div>
                                    <div class="media media-single box-shadowed bg-white pull-up mb-0"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary text-overflow-h nowrap">Host, Date
                                                &
                                                Venue</h5>
                                            <small class="text-fade">Venue: Morogoro, Tanzania</small>
                                            <p><small class="text-fade mt-10">Date: June 2023</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 " data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12">
                    <h2 class="mb-10 text-primary">About Kilimo Award</h2>
                    <hr>
                    <p class="fs-16">The KILIMO Awards are by far the biggest and most prestigious awards in Tanzania
                        farming. Every year we review our award categories to ensure they better reflect the range of
                        achievements that deserve recognition in the rapidly-changing world of agriculture.</p>
                    @if (isAwardActive())
                        <a href="{{ route('web.event.award.registration') }}" class="btn btn-primary">Register As
                            Nominee</a>
                    @endif
                </div>
                <div class="col-lg-6 col-12 position-relative">
                    <div class="popup-vdo mt-30 mt-md-0">
                        <img src="{{ asset('images/award-1.jpg') }}" class="img-fluid rounded" alt="Awards"
                            loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 bg-white" data-aos="fade-up">
        <div class="container">
            <div class="box-body p-0 py-20">
                <div class="row align-items-center">
                    <div class="col-md-12 col-lg-6">
                        <div class="popup-vdo mt-30 mt-md-0">
                            <img src="{{ asset('images/marathon-1.jpg') }}" class="img-fluid rounded" alt="Awards"
                                loading="lazy">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 pt-20 ">
                        <h4 class="box-title mb-0 fw-500">Kilimo Marathon Events</h4>
                        <hr>
                        <ul class="course-overview list-unstyled b-1">
                            <li><i class="me-10 mdi mdi-run"></i> <span class="tag">21 Km running distance</span>
                                <span class="value">Tsh 35,000/=</span>
                            </li>
                            <li><i class="me-10 mdi mdi-run"></i> <span class="tag">10 Km running distance</span>
                                <span class="value">Tsh 35,000/=</span>
                            </li>
                            <li><i class="me-10 mdi mdi-run"></i> <span class="tag">5 Km running distance</span>
                                <span class="value">Tsh 35,000/=</span>
                            </li>
                        </ul>
                        @if (isMarathonActive())
                            <div class="entry-button text-center ">
                                <a href="{{ route('web.event.marathon.registration') }}"
                                    class="btn btn-primary btn-sm">Marathon Registration</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 " data-aos="fade-up">
        <div class="container">
            <div class="row mt-30 div-list">
                <div class="col-md-3 col-12 div-list-item">
                    <div class="box pull-up">
                        <div class="box-body">
                            <div>
                                <div class="d-flex align-items-center mb-30">
                                    <div class="me-15">
                                        <span class="icon-Group text-primary fs-40"><i class="me-10 mdi mdi-run-fast"
                                                aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column fw-500">
                                        <a class="text-dark hover-primary mb-1 fs-16">Marathon Lenght</a>
                                    </div>
                                </div>
                                <p class="mb-2">The Marathon will be of various lengths such as 21km, 10km and 5km
                                    within Morogoro</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 div-list-item">
                    <div class="box pull-up">
                        <div class="box-body">
                            <div>
                                <div class="d-flex align-items-center mb-30">
                                    <div class="me-15">
                                        <span class="icon-Group text-primary fs-40"><i class="me-10 mdi mdi-trophy"
                                                aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column fw-500">
                                        <a class="text-dark hover-primary mb-1 fs-16">Kilimo Awards</a>
                                    </div>
                                </div>
                                <p class="mb-2">This will be held at the end of the marathon to acknowledge game
                                    changers in the agriculture sector. Several categories will be created allowing the
                                    general public to nominate nominees.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 div-list-item">
                    <div class="box pull-up">
                        <div class="box-body">
                            <div>
                                <div class="d-flex align-items-center mb-30">
                                    <div class="me-15">
                                        <span class="icon-Group text-primary fs-40"><i class="me-10 mdi mdi-tent"
                                                aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column fw-500">
                                        <a class="text-dark hover-primary mb-1 fs-16">Kilimo Expo</a>
                                    </div>
                                </div>
                                <p class="mb-2">There will be an exhibition of various technologies and innovations
                                    in value chain of which the attendees will have the opportunity to learn the latest
                                    techniques.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 div-list-item">
                    <div class="box pull-up">
                        <div class="box-body">
                            <div>
                                <div class="d-flex align-items-center mb-30">
                                    <div class="me-15">
                                        <span class="icon-Group text-primary fs-40"><i class="me-10 mdi mdi-walk"
                                                aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column fw-500">
                                        <a class="text-dark hover-primary mb-1 fs-16">Event Entry</a>
                                    </div>
                                </div>
                                <p class="mb-2">Except for Marathon runners, Exhibitors and other service providers,
                                    there will be NO ENTRY FEE for anybody who wishes to enter into the exhibition.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 bg-white" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-12 text-center">
                    <h1 class="mb-15">PROMOTION STRATEGY</h1>
                    <hr class="w-100 bg-primary">
                </div>
            </div>
            <div class="row mt-30 div-list">
                <div class="col-lg-4 col-md-4 col-12 div-list-item">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('images/sponsor4.jpg') }}" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Pre - Marathon</h4>
                            <p class="card-text">Our goal during this stage will be to create awareness and achieve
                                maximum conversion to turn people’s interest into the agricultural marathon.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12 div-list-item">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('images/IMG_6380.jpg') }}" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title text-primary">During Marathon</h4>
                            <p class="card-text">To make sure Kilimo Marathon reaches the finishing line with flying
                                colors, we will share regular updates on social media, updates and pictures of the
                                venue, collaterals (T-shirts), attendees, chief guests and interesting facts, etc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12 div-list-item">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('images/KILIMO MOROGORO-205.jpg') }}"
                            alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Post - Marathon</h4>
                            <p class="card-text">Our attendees of this marathon run are the first targets of our future
                                events. Hence, Kilimo marathon will be accompanied with two special events as a warm
                                note so that we leave a lasting impression.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 " data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12 position-relative">
                    <div class="popup-vdo mt-30 mt-md-0">
                        <img src="{{ asset('images/IMG_5276.jpg') }}" class="img-fluid rounded" alt="Awards"
                            loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6 col-12 pt-20">
                    <h2 class="mb-10 text-primary">Kilimo Expo</h2>
                    <hr>
                    <p class="fs-16">The Kilimo Expo, held once in a year, is one of the leading Agriculture Events of
                        its kind to showcase various products, produce, and services in the agricultural sector
                        (crop,livestock, Fisheries and agri-tech). This Agriculture Exhibition attracts many Ministers
                        of Agriculture,decision-makers, experts, practitioners and trainers in agriculture, as well as
                        thousands of visitors from all around the Tanzania.</p>
                    <a href="{{ route('web.event.expo.registration') }}" class="btn btn-primary text-center">Register
                        As
                        Exhibitor</a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 bg-white" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-12 text-center">
                    <h1 class="mb-15">Our Partners.</h1>
                    <hr class="w-100 bg-primary">
                </div>
            </div>
            <div class="row mt-30">
                <div class="col-12">
                    <div class="owl-carousel owl-theme owl-btn-1" data-nav-arrow="false" data-nav-dots="false"
                        data-items="6" data-md-items="4" data-sm-items="3" data-xs-items="2" data-xx-items="2">
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-1.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-2.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-3.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-4.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-5.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-6.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-7.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-8.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-9.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-10.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-11.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        <div class="item"><img src="../images/front-end-img/unilogo/uni-12.jpg"
                                class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
