@php($title = 'Agribusiness Exhibition')
@php($pageTitle = 'kilimo_expo')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <x-web.layout.page-slider-component :page="$pageTitle" />
                <div class="box-body">
                    <h4 class="box-title mb-0 fw-500">Agribusiness Exhibition</h4>
                    <hr>
                    <p class="fs-16 mb-10">The exhibition segment of the Kilimo Expo provides a vibrant platform for
                        businesses, organizations, and innovators in the agricultural sector to showcase their products,
                        services, and technologies. Exhibitors, including agritech companies, seed and fertilizer
                        suppliers, machinery manufacturers, and agricultural startups, set up booths to display their
                        offerings. This segment features live demonstrations of new agricultural technologies,
                        machinery, and sustainable farming practices, providing attendees with firsthand experience and
                        insights.</p>
                    <p class="fs-16 mb-10">Educational sessions and workshops are a cornerstone of the exhibition, led by
                        experts on topics such as modern farming techniques, smart agriculture, and sustainable
                        practices. These sessions aim to educate and inspire attendees, offering valuable knowledge and
                        skills that can be applied to their own agricultural endeavors. Networking opportunities abound,
                        facilitating connections between farmers, agribusiness professionals, researchers, and
                        investors. The primary objectives of the exhibition are to promote innovation in agriculture,
                        provide farmers with access to new tools and technologies, and foster collaboration and
                        knowledge exchange within the agricultural community.</p>

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="box-title mb-0 fw-500">Please Note!</h4>
                            <hr>
                            <ul class="list list-mark">
                                <li>Both local and International Exhibitors are welcome</li>
                                <li>Exhibitors in any value chain or related products/services</li>
                                <li>Exhibitors with products/services beyond agriculture are
                                    also welcome</li>
                            </ul>
                            <hr>
                            <div class="entry-button">
                                <a href="{{ route('web.event.expo.registration') }}"
                                    class="btn btn-primary btn-sm">Click to register for Agribusiness Expo</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web.layout.app-layout>
