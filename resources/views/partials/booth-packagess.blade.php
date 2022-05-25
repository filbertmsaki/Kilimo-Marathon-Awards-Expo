<section id="pricing" class="" style="padding: 50px 0 50px 0;background-color: #006837;">
    <div class="container">
    <h1 class="section-title wow fadeInUpQuick animated" data-wow-delay=".2s" style="visibility: visible;-webkit-animation-delay: .2s; -moz-animation-delay: .2s; animation-delay: .2s;">
        <p style="color:#fff;">Partnership Packages</p>
    </h1>
    <p class="section-subcontent wow fadeInUpQuick animated" data-wow-delay=".3s" style="margin: 20px auto 0 ;visibility: visible;-webkit-animation-delay: .3s; -moz-animation-delay: .3s; animation-delay: .3s;">
      </p>
   
    <div class="row">
        <div class="col-md-6 wow animated" style="visibility: visible;">
        <div class="pricing-table pricing-table-x active">
            <div class="table-header">
                <h3>
                    Exhibition Booth
                </h3>
            </div>
            <div class="plan">
                <h3 class="price">
                    1, 000, 000<span>Tsh</span>
                </h3>
                <span class="per">Corporate</span>

            </div>
            <hr>
            <div class="plan-info">
            <ul class="u-list" style="font-size: 11px;">
                <li style="list-style-type: ' \00B7';">Tent </li>
                <li style="list-style-type: ' \00B7';"> Complimentary tickets for marathon</li>
                <li style="list-style-type: ' \00B7';"> Markting and Sales </li>
                <li style="list-style-type: ' \00B7';"> Promotion on social medias </li>
                <li style="list-style-type: ' \00B7';"> Certificate of participation </li>
                <li style="list-style-type: ' \00B7';"> Photos and Video Coverage </li>
                <li style="list-style-type: ' \00B7';"> Handing the awards to the winner  </li>
                <li style="list-style-type: ' \00B7';"> Interview  </li>
            </ul>
            </div>
            <div class="button-area">
            <form class="shake contactForm"  action="{{ route('order_store')}}" method="post">
                @csrf
                <input type="hidden"  name="package_name" value="Exhibition Booth">
                <input type="hidden"  name="package_amount" value="1000000">
                <button class="btn btn-common" type="submit" value="submit" name="submit">Pay Now</button>
            </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="pricing-table pricing-table-x ">
            <div class="table-header highlight">
                <h3>
                    Service Provider Booth
                </h3>
            </div>
            <div class="plan ">
                <h3 class="price">
                    500, 000<span>Tsh</span>
                </h3>
                <span class="per">Entrepreneur</span>

            </div>
            <hr>
            <div class="plan-info">
                <ul style="font-size: 11px;">
                    <li style="list-style-type: ' \00B7';">Tent </li>
                    <li style="list-style-type: ' \00B7';"> Markting and Sales </li>
                    <li style="list-style-type: ' \00B7';"> Certificate of participation </li>
                    <li style="list-style-type: ' \00B7';"> Photos and Video Coverage </li>
                    <li style="list-style-type: ' \00B7';"> Interview </li>
                </ul>
            </div>
            <div class="button-area">
                <form class="shake contactForm"  action="{{ route('order_store')}}" method="post">
                    @csrf
                    <input type="hidden"  name="package_name" value="Service Provider Booth">
                    <input type="hidden"  name="package_amount" value="500000">
                    <button class="btn btn-common" type="submit" value="submit" name="submit">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>