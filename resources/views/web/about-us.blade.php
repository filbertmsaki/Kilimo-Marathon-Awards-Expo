@php($title = 'About Us')

<x-web.layout.app-layout :isPagetitle="true" :pageTitle='$title'>
    <!--Page content -->
    <section class="py-50 bg-white">
        <div class="container">
            <div class="box m-0">
                <div class="box-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="box-title mb-0 fw-500">About Kilimo Marathon, Awards & Expo</h4>
                            <hr>
                            <p class="fs-16">
                                The Third Annual KILIMO Marathon and Expo is an event that has been conducted in the
                                Morogoro Region for three consecutive years. The event is a platform dedicated to
                                promoting and showcasing the agriculture sector, with a focus on inspiring and engaging
                                the youth. It aims to change the negative attitudes and behaviors of young individuals
                                towards agribusiness and expose them to the numerous opportunities it offers.

                            </p>
                            <p class="fs-16">
                                The event features various activities designed to achieve its objectives. These
                                activities include the KILIMO Marathon, which takes place on the final day of the event,
                                and offers participants the chance to compete in different distances such as the 42.2 Km
                                Full Marathon, 21.1 Km Half Marathon, 10 Km Fun Run, and 5 Km Fun Run.
                            </p>

                        </div>
                        <div class="col-md-6 col-12">
                            <p class="fs-16">
                                Additionally, the event includes an Agricultural Expo, Moro Mpya ya Kijani campaign, and
                                a range of sport activities including cycling, netball, football skills competition, tug
                                of war, and sack race.
                            </p>
                            <p class="fs-16">By hosting the event in the Morogoro Region for three years in a row, it
                                has become an established platform that attracts a diverse audience including youth,
                                agribusiness professionals, government officials, industry experts, and the general
                                public. The event serves as an opportunity to highlight the potential and opportunities
                                within the agriculture industry, complementing the initiatives of the Government through
                                the Ministry of Agriculture.
                            </p>
                            <p class="fs-16">The Third Annual KILIMO Marathon and Expo is not only a celebration of
                                agriculture but also a catalyst for positive change. It aims to create awareness, foster
                                sustainable practices, and inspire individuals to build a better future through
                                agribusiness. Through networking, collaboration, and the sharing of knowledge and
                                experiences, the event aims to contribute to the growth and development of the
                                agriculture sector in the region and beyond.
                            </p>
                            <a href="{{ route('web.contactUs') }}" class="btn btn-primary">Contact Us</a>
                        </div>
                        <div class="col-md-6 col-12 position-relative">
                            <div class="popup-vdo mt-30 mt-md-0">
                                <img src="{{ asset('images/IMG_5273.jpg') }}" class="img-fluid rounded" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web.layout.app-layout>
