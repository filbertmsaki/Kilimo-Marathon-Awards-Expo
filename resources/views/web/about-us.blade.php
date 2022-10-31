<x-web.layout.app-layout :isPagetitle="true" :pageTitle='"About Us"'>
    <!--Page content -->

    <section class="py-50 bg-white">
        <div class="container">
            <div class="box m-0">
                <div class="box-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="box-title mb-0 fw-500">About Kilimo Marathon, Awards & Expo</h4>
                        <hr>
                            <p class="fs-16">Kilimo Marathon, Awards & EXPO will be a run and exhibition which will
                                theme Agriculture sector in general for the aim of helping us realizing our main goal
                                which is reveal a tangible support in Tanzania’s agricultural growth by realizing an
                                increase in investments and sales of agricultural products.</p>

                        </div>
                        <div class="col-md-6 col-12">
                            <p class="fs-16">The Marathon will be of various length namely 21km,10km and 5km within the
                                Morogoro.here will be an exhibition of various technologies and innovations in value
                                chain of which the attendees will have the opportunity to learn the latest techniques
                                and innovations in production, marketing, processing, and services provided in the
                                agricultural sector such as financial services, inputs, insurance, Digitization,
                                mechanization, and others.</p>
                            <p class="fs-16">Exhibitors will come from different nodes of the value chain including the
                                producers of agricultural products, livestock and fisheries, processors, services
                                providers (Finance, insurance, inputs, mechanization, consultancy, researchers),
                                traders, transporters, ICT (Digitization), exporters, and so on.It is expected that
                                Kilimo Marathon, Awards & EXPO will be an avenue for G2B, B2B, and B2C engagements.</p>
                            <p class="fs-16">The government leaders amongst them sectoral ministers and permanent
                                secretaries are expected to engage and participate this year’s theme which is a mark of
                                the first sport themed event for agriculture.</p>
                            <a href="{{ route('web.contactUs') }}" class="btn btn-primary">Contact Us</a>
                        </div>
                        <div class="col-md-6 col-12 position-relative">
                            <div class="popup-vdo mt-30 mt-md-0">
                                <img src="{{ asset('images-s/IMG_5273.jpg') }}" class="img-fluid rounded"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web.layout.app-layout>
