@php($title = 'Agri-Tourism')
@php($pageTitle = ' agri_tourism ')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <x-web.layout.page-slider-component :page="$pageTitle" />
                <div class="box-body">
                    <h4 class="box-title mb-0 fw-500">Agri-Tourism</h4>
                    <hr>
                    <p class="fs-16 mb-10">The agri-tourism segment of the Kilimo event combines agriculture and tourism to offer visitors an immersive experience in farming activities and rural life. This segment provides a unique opportunity to educate the public about agriculture while promoting local cultures and traditions. Farm tours offer guided visits to local farms, allowing visitors to learn about different crops, livestock, and farming techniques. These tours provide a hands-on experience, giving attendees a deeper understanding of the agricultural processes that sustain our communities.</p>
                    <p class="fs-16 mb-10">Harvesting experiences are another highlight, where visitors can participate in activities such as picking fruits and vegetables or harvesting crops. Interactive workshops cover traditional farming methods, organic farming, and sustainable practices, offering valuable insights and skills to participants. Cultural events showcase local traditions, food, music, and crafts, providing a rich cultural experience alongside agricultural education. Farm stays offer accommodations on farms, allowing visitors to experience rural life firsthand and gain a deeper appreciation for the hard work and dedication of farmers. The objectives of the agritourism segment are to promote agricultural education and awareness, support local farmers and rural economies, and enhance the tourism appeal of the region by offering unique and educational experiences.</p>

                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div class="entry-button btn-group">
                                <a href="#"
                                    class="b-0 waves-effect waves-light btn btn-primary btn-sm rounded-0">Click to register for Agri tourism</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
