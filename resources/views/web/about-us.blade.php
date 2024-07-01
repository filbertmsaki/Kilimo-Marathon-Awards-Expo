@php($title = 'About Us')

<x-web.layout.app-layout :isPagetitle="true" :pageTitle='$title'>
    <!--Page content -->
    <section class="py-50 bg-white">
        <div class="container">
            <div class="box m-0">
                <div class="box-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="box-title mb-0 fw-500">About the Kilimo Marathon, Awards & Expo</h4>
                            <hr>
                            <p class="fs-16">The Kilimo Marathon, Awards & Expo is an annual event dedicated to
                                transforming the agricultural landscape in Tanzania. With the theme of "Transforming
                                Youths' Mindset in Agriculture," we aim to inspire and empower the next generation of
                                farmers and agribusiness leaders. The event is organized by Shambadunia Limited in
                                collaboration with Morogoro Regional Commissioner’s Office, TCCIA Morogoro, SAGCOT and
                                other stakeholders</p>

                            <h4 class="box-title mb-0 fw-500">Our Mission
                            </h4>
                            <div>
                                <ul>
                                    <li>To create awareness about the vast opportunities in the agricultural sector.
                                    </li>
                                    <li>To foster a positive attitude towards agriculture among young people.</li>
                                    <li>To promote innovation and technology adoption in farming practices.</li>
                                    <li>To showcase the diverse agricultural products and services available in
                                        Tanzania.</li>
                                </ul>
                            </div>

                            <div class="mt-10">
                                <h4 class="box-title mb-0 fw-500">What to Expect</h4>
                                <div>
                                    <ul>
                                        <li><b>Kilimo Marathon:</b> A unique sporting event that celebrates the spirit
                                            of agriculture</li>
                                        <li><b>Awards Ceremony:</b> Recognizing outstanding achievements in the
                                            agricultural sector.</li>
                                        <li><b>Expo:</b> A vibrant marketplace for agricultural products, technologies,
                                            and services.</li>
                                        <li><b>Cycling Event:</b> Promoting sustainable and healthy practices in
                                            agriculture.</li>
                                        <li><b>Agro-tourism Activities:</b> Showcasing the beauty and potential of rural
                                            Tanzania.</li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 col-12 position-relative">
                            <div class="popup-vdo mt-30 mt-md-0">
                                <img src="{{ asset('images/2024/GeneralDesign.jpg') }}" class="img-fluid rounded"
                                    alt="">
                            </div>
                        </div>
                    </div>
                 
                    <p>Join us as we run, cycle, explore, and celebrate the future of agriculture in Tanzania. Together,
                        we can transform the mindset of our youth and build a prosperous agricultural sector.</p>
                </div>
            </div>
        </div>
    </section>

</x-web.layout.app-layout>
