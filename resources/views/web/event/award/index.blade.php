@php($title = 'Awards and Panel Discussions')
@php($pageTitle = 'kilimo_award')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <x-web.layout.page-slider-component :page="$pageTitle" />
                <div class="box-body">
                    <h4 class="box-title mb-0 fw-500">Awards and Panel Discussions</h4>
                    <hr>
                    <p class="fs-16 mb-10">The awards segment of the Kilimo event is dedicated to recognizing and celebrating excellence and innovation in the agricultural sector. This segment honors individuals, companies, and organizations that have made significant contributions to agriculture through various award categories. The Best Farmer Award recognizes outstanding farmers who have demonstrated excellence in farming practices and productivity. The Innovative Agribusiness Award honors businesses that have introduced innovative products or services in the agricultural sector, driving progress and efficiency.</p>
                    <p class="fs-16 mb-10">Sustainable practices are highlighted through the Sustainable Agriculture Award, which acknowledges those who have implemented environmentally friendly and sustainable farming methods. The Young Agripreneur Award celebrates young individuals who have shown exceptional entrepreneurial skills in agriculture, encouraging the next generation of agricultural leaders. The Community Impact Award recognizes projects or individuals who have made a significant positive impact on their communities through agricultural initiatives. By celebrating these achievements, the awards segment aims to encourage innovation and excellence in agriculture, inspire others in the agricultural community, and highlight contributions to sustainable farming practices</p>

                    <div class="row">
                        <div class="col-md-12">

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
                                <a href="#"
                                    class="b-0 waves-effect waves-light btn btn-primary btn-sm rounded-0">Click to register for Awards as nominee</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
