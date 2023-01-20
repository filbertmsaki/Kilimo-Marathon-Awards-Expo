@php($title = 'Mkulima Awards (Mashujaa wa Kilimo wa Mama Samia)')
@php($pageTitle = 'kilimo_award')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <x-web.layout.page-slider-component :page="$pageTitle" />
                <div class="box-body">
                    <h4 class="box-title mb-0 fw-500">Mkulima Awards</h4>
                    <hr>
                    <p class="fs-16 mb-30">Mkulima Awards are awards presented by Morogoro Regional
                        Commisioner and Shambadunia Ltd to more tha 40 Agriculture Sector
                        key players, Emerging Farmers and many stakeholders in various
                        categories for recognizing the contribution and importance of farmers
                        and stakeholders of the agricultural sector in Tanzania.</p>
                    <p class="fs-16 mb-30">Every year we review our award categories to ensure they better
                        reflect the range of achievements that deserve recognition in the
                        rapidly-changing world of agriculture.
                    </p>

                    <div class="row">
                        <div class="col-md-12 col-lg-6">

                            <h4 class="box-title mb-0 fw-500">Please Note!</h4>
                            <hr>
                            <ul class="list list-mark">
                                <li> Nomination Fee per award category is FREE</li>
                                <li> After registering to participate in the awards, you will be required to fill in
                                    your personal/company information on the profile page</li>
                                <li> After nominee verification complete the voting window will be open, and you
                                    notified through the emails</li>
                            </ul>
                            <hr>
                            <div class="entry-button btn-group">
                                <a href="{{ route('web.event.award.category.index') }}"
                                    class="btn btn-warning btn-sm rounded-0">View Award Categories</a>
                                @if (isAwardActive())
                                    <a href="{{ route('web.event.award.registration') }}"
                                        class="b-0 waves-effect waves-light btn btn-primary btn-sm rounded-0">Register
                                        As Nominee</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <h4 class="box-title mb-0 fw-500">Calender</h4>
                            <hr>
                            <ul class="course-overview list-unstyled b-1 bg-gray-100">
                                <li><i class="ti-calendar"></i> <span class="tag">Event Date </span> <span
                                        class="value"> June 2023</span></li>
                                <li><i class="fa fa-street-view"></i> <span class="tag">Venue </span> <span
                                        class="value">Morena Hotel, Morogoro.</span></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
