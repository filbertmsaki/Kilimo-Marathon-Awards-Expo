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
                    <p class="fs-16 mb-10"><strong> Purpose and objectives of the event:</strong> The purpose of the
                        event is to educate and inspire youth to participate in agriculture and promote sustainable
                        farming practices. The event will also call for people to plant trees as an action or cause to
                        impact the environment positively.
                    </p>
                    <p class="fs-16 mb-10"><strong>Importance of the event: </strong> The event is important because it
                        will promote sustainable agriculture and environmental conservation in Tanzania, and provide
                        opportunities for youth to learn about agriculture and participate in sports activities.
                        Event Description
                    </p>
                    <p class="fs-16 mb-10"><strong>Types of activities: </strong>The event will feature an agriculture exhibition and various sports activities like mar- athon, half marathon, fun run, netball, grass root football skills competitions, suck race and tag of war. There will be something for everyone, from serious runners to those who just want to have fun.
                        Target Audience
                        </p>
                    <p class="fs-16 mb-10"></p>
                    <p class="fs-16 mb-10"></p>
                    <p class="fs-16 mb-10"></p>
                    <p class="fs-16 mb-10"></p>
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
                                        class="value"> 23 September2023</span></li>
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
