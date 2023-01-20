@php($title = 'Kilimo Marathon')
@php($pageTitle = 'kilimo_marathon')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <x-web.layout.page-slider-component :page="$pageTitle" />

                <div class="box-body">
                    <h4 class="box-title mb-0 fw-500">Kilimo Marathon</h4>
                    <hr>
                    <p class="fs-16 mb-30">Kilimo Marathon, Awards & Expo is a unique agro sports Event in East
                        Africa, Tanzania. With the aim of offering a tangible support in
                        Tanzania’s agricultural growth by realizing an increase in investments
                        and sales of agricultural products.</p>
                    <p class="fs-16 mb-30">The Kilimo Marathon Event has various sports activities including 42.2
                        Km Full Marathon, 21.1 Km Half Marathon, 10 Km Fun Run, 5 Km Fun
                        Run, Cycling - Mountain biking, Football Skills competition, Tug of
                        War, Sack race</p>
                    <div class="row">
                        <div class="col-md-12 col-lg-6">

                            <h4 class="box-title mb-0 fw-500">Please Note!</h4>
                            <hr>
                            <ul class="list list-mark">
                                <li> Registration Fee per run distance is Tsh 35,000/- including T-Shirt & BIB number.
                                </li>
                                <li> After you fill the details , the form has to be submitted & then you will be lead
                                    to the payment page.</li>
                                <li> Or you can choose to pay the running fee using our LIPA NUMBER instead of
                                    registering in the website</li>
                            </ul>
                            @if (isMarathonActive())
                                <hr>
                                <div class="entry-button">
                                    <a href="{{ route('web.event.marathon.registration') }}"
                                        class="btn btn-primary btn-sm">Marathon Registration</a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <h4 class="box-title mb-0 fw-500">Calender</h4>
                            <hr>
                            <ul class="course-overview list-unstyled b-1 bg-gray-100">
                                <li><i class="ti-calendar"></i> <span class="tag">Event Date </span> <span
                                        class="value"> 3 June-2023</span></li>
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
