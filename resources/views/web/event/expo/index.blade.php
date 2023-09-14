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
                    <p class="fs-16 mb-10">A 3 days agriculture exhibition event is a unique platform for farmers,
                        agricultural businesses, researchers, and stakeholders to showcase the latest innovations,
                        technologies, products, and services in the agricultural sector. The event provides a forum for
                        exchanging knowledge, ideas, and experiences that can lead to new business opportunities,
                        partnerships, and collaborations.
                    </p>
                    <p class="fs-16 mb-10">We cordially invite all stakeholders in the agriculture sector, including
                        farmers, agricultural businesses, re- searchers, policymakers, investors, and non-governmental
                        organizations, to participate in this year’s agri- culture exhibition event. This is an
                        excellent opportunity for you to showcase your latest products, services, and research findings
                        to a global audience. </p>
                    <p class="fs-16 mb-10">By participating in this event, you will have a chance to network with other
                        stakeholders, exchange knowledge and ideas, and explore new business opportunities and
                        collaborations. Don’t miss this chance to be a part of the agriculture sector’s most significant
                        event of the year. Register now to secure your place in the exhibition and take advantage of
                        this unique opportunity to showcase your expertise and innovation</p>


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
                                        class="value"> 7 - 14 October 2023</span></li>
                                <li><i class="fa fa-street-view"></i> <span class="tag">Venue </span> <span
                                        class="value">Gairo, Morogoro</span></li>

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web.layout.app-layout>
