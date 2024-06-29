@php($title = 'Marathon, Cycling')
@php($pageTitle = 'kilimo_marathon')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <x-web.layout.page-slider-component :page="$pageTitle" />

                <div class="box-body">
                    <h4 class="box-title mb-0 fw-500">Marathon, Cycling</h4>
                    <hr>
                    <p class="fs-16 mb-10">The sports segment of the Kilimo Marathon is designed to bring together
                        athletes, farmers, and enthusiasts from various backgrounds. The marathon, a central event,
                        promotes physical fitness and community spirit through long-distance running races. Participants
                        can choose from categories such as the half marathon (21.097 km), and a 10 km run, accommodating
                        different fitness levels. This event is open to professional athletes, amateur runners, local
                        communities, and corporate teams, fostering a sense of unity and healthy living. The marathon
                        aims to raise awareness about agricultural practices and encourage healthy lifestyles while
                        engaging the community in a fun and challenging activity.</p>
                    <p class="fs-16 mb-10">In addition to the marathon, the cycling event offers both competitive and
                        recreational options. This event emphasizes eco-friendly transportation and provides an
                        opportunity to explore the beautiful rural landscapes.The road racing inviting cyclists of all
                        skill levels to participate. The objectives are to highlight the importance of sustainable
                        transportation, showcase scenic agricultural routes, and promote physical activity among
                        participants. By integrating sports into the Kilimo event, we aim to create a dynamic and
                        engaging experience that underscores the importance of health and sustainability.</p>

                    <div class="row">
                        <div class="col-md-12">

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
                            {{-- @if (isMarathonActive()) --}}
                            <hr>
                            <div class="entry-button">
                                <a href="{{ route('web.event.marathon.registration') }}"
                                    class="btn btn-primary btn-sm">Click to register for Marathon or Cycling</a>
                            </div>
                            {{-- @endif --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web.layout.app-layout>
