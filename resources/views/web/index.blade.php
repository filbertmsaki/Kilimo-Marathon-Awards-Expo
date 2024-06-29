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
                                <h1 class="mb-15 text-center fs-2">KILIMO MARATHON, AWARDS AND EXPO</h1>
                                <p class="fs-22">The Third Annual KILIMO Marathon and Expo is an event that has been
                                    conducted in the Morogoro Region for three consecutive years. The event is a
                                    platform dedicated to promoting and showcasing the agriculture sector, with a focus
                                    on inspiring and engaging the youth.
                                </p>

                                <a href="{{ route('web.aboutUs') }}" class="btn  btn-primary">Read More</a>
                            </div>
                            <div class="col-lg-6 col-12 position-relative">
                                <div class="media-list media-list-hover media-list-divided md-post mt-lg-0 mt-30">
                                    <div class="media media-single box-shadowed bg-white pull-up mb-15"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary  text-overflow-h nowrap">Objective
                                            </h5>
                                            <p>
                                                The main objective of the Third Annual KILIMO Marathon and Expo is to
                                                change the negative attitude/behavior of youth toward agribusiness,
                                                expose them to agribusiness opportunities, and encourage them to
                                                consider it as a viable career path. </p>
                                        </div>
                                    </div>
                                    <div class="media media-single box-shadowed bg-white pull-up mb-15"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary  text-overflow-h nowrap">Theme
                                            </h5>
                                            <p>“Transforming Youth Mindset in Agriculture”.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="media media-single box-shadowed bg-white pull-up mb-15"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary  text-overflow-h nowrap">Target
                                                Audience
                                            </h5>
                                            <p>Youth (Aged 18-40 years): The event specifically aims to engage and
                                                inspire young individuals within the age range of 18 to 40 years.

                                            </p>
                                        </div>
                                    </div>
                                    <div class="media media-single box-shadowed bg-white pull-up mb-0"
                                        style="cursor: pointer">
                                        <div class="media-body fw-500">
                                            <h5 class="overflow-hidden text-primary text-overflow-h nowrap">Host, Date
                                                &
                                                Venue</h5>
                                            <small class="text-fade">Venue: Morogoro Secondary school, Morogoro.
                                                Tanzania</small>
                                            <p><small class="text-fade mt-10">Date: 2<sup>nd</sup> - 5<sup>th</sup>
                                                    October, 2024</small></p>
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
                    <h2 class="mb-10 text-primary">The Mkulima Awards</h2>
                    <hr>
                    <p class="fs-16">
                        The Mkulima Awards is an annual event that celebrates excellence and innovation in agriculture
                        in Tanzania. The awards recognize farmers, agribusinesses, and organizations that have made
                        outstanding contributions to the agriculture sector through their innovation, productivity, and
                        sustainability practices.
                        The event is open to all individuals, organizations, and companies involved in agriculture,
                        including farmers, pro- cessors, input providers, researchers, and innovators. Participants can
                        submit their entries in various categories, such as crop production, livestock farming,
                        agribusiness, and research and innovation through the website.

                    </p>
                    <div class="btn-group">
                        <a href="{{ route('web.event.award.index') }}" class="btn btn-success">Read More</a>
                        @if (isAwardActive())
                            <a href="{{ route('web.event.award.registration') }}" class="btn btn-primary">Register As
                                Nominee</a>
                        @endif
                    </div>

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
                        <h4 class="box-title mb-0 fw-500">Main Event Activities</h4>
                        <hr>
                        <div>
                            <ul class="course-overview list-unstyled b-1">
                                <li><span>2<sup style="margin-right: 5px">nd</sup> October – </span> Awards Ceremony and
                                    Expo Launch</li>

                                <li><span>3<sup style="margin-right: 5px">rd</sup> October – </span> Exhibition, Other
                                    sports on ground</li>
                                <li><span>4<sup style="margin-right: 5px">th</sup> October – </span> Agri- Tourism,
                                    Exhibition</li>
                                <li><span>5<sup style="margin-right: 5px">th</sup> October –</span> Half Marathon (21 Km
                                    run), 10 Km Fun run and 5 Km Fun run,
                                    Cycling 40 km</li>

                            </ul>
                        </div>

                        @if (isMarathonActive())
                            <div class="entry-button text-center mt-10 ">
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
                                <p class="mb-2">The Marathon will be of various lengths such as 21km, 10km
                                    and 5km within Morogoro
                                </p>
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
                                <p class="mb-2">This will be held at the beginning of the event to set pace and
                                    acknowledge game changers in
                                    the agriculture sector. Several categories will be created allowing the general
                                    public to
                                    nominate nominees.</p>
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
                                        <a class="text-dark hover-primary mb-1 fs-16">Agri-Tourism</a>
                                    </div>
                                </div>
                                <p class="mb-2">Participants from across the country will have an opportunity to have
                                    field visits to various
                                    attractions in Morogoro including farms and other natural attractions</p>
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
                    <p class="fs-16"> A 3 days agriculture exhibition event is a unique platform for farmers,
                        agricultural businesses, researchers, and stakeholders to showcase the latest innovations,
                        technologies, products, and services in the agricultural sector. The event provides a forum for
                        exchanging knowledge, ideas, and experiences that can lead to new business opportunities,
                        partnerships, and collaborations.
                    </p>
                    <div class="btn-group">
                        <a href="{{ route('web.event.expo.index') }}" class="btn btn-success text-center">Read
                            More</a>
                        <a href="{{ route('web.event.expo.registration') }}"
                            class="btn btn-primary text-center">Register
                            As
                            Exhibitor</a>
                    </div>

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
                <style>
                    .partner-item {
                        max-width: 200px;
                        max-height: 100px;
                    }
                </style>
                <div class="col-12">
                    <div class="partner owl-carousel owl-theme owl-btn-1" data-nav-arrow="false"
                        data-nav-dots="false" data-items="6" data-md-items="4" data-sm-items="3" data-xs-items="3"
                        data-xx-items="2">


                        @foreach ($partners as $item)
                            <div class="item partner-item"><img src="{{ asset($item->image_url) }}"
                                    class="img-fluid my-15 rounded box-shadowed pull-up" alt=""></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
