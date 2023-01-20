@php($title = 'Kilimo Expo')
@php($pageTitle = 'kilimo_expo')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <x-web.layout.page-slider-component :page="$pageTitle" />
                <div class="box-body">
                    <h4 class="box-title mb-0 fw-500">Kilimo Expo</h4>
                    <hr>
                    <p class="fs-16 mb-30">The Kilimo Expo, held once in a year, is one of the leading Agriculture
                        Events of its kind to showcase various products, produce, and services in the agricultural
                        sector (crop,livestock, Fisheries and agri-tech). This Agriculture Exhibition attracts many
                        Ministers of Agriculture,decision-makers, experts, practitioners and trainers in agriculture, as
                        well as thousands of visitors from all around the Tanzania.</p>
                    <p class="fs-16 mb-30"></p>

                    <div class="row">
                        <div class="col-md-12 col-lg-6">

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
                                <a href="{{ route('web.event.expo.registration') }}" class="btn btn-primary btn-sm">Expo
                                    Registration</a>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <h4 class="box-title mb-0 fw-500">Calender</h4>
                            <hr>
                            <ul class="course-overview list-unstyled b-1 bg-gray-100">
                                <li><i class="ti-calendar"></i> <span class="tag">Event Date </span> <span
                                        class="value">1-3 June-2023</span></li>
                                <li><i class="fa fa-street-view"></i> <span class="tag">Venue </span> <span
                                        class="value">Jamuhuri Stadium, Morogoro</span></li>

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web.layout.app-layout>
