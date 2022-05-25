<section id="pricing" class="" style="padding: 50px 0 50px 0;">
    <div class="container">
    <h1 class="section-title wow fadeInUpQuick animated" data-wow-delay=".2s" style="visibility: visible;-webkit-animation-delay: .2s; -moz-animation-delay: .2s; animation-delay: .2s;">
        Sponsorship Packages
    </h1>
    <p class="section-subcontent wow fadeInUpQuick animated" data-wow-delay=".3s" style="margin: 20px auto 0 ;visibility: visible;-webkit-animation-delay: .3s; -moz-animation-delay: .3s; animation-delay: .3s;">
        Therefore, SDL is planning to mobilize fund resources for the event from 
    different sponsors. Below is the sponsorship package for those who will be willing to support and be part of the success of this event. 
    </p>
    <p class="section-subcontent wow fadeInUpQuick animated" data-wow-delay=".3s" style="margin: 20px auto 0 ;color:#00502b;visibility: visible;-webkit-animation-delay: .3s; -moz-animation-delay: .3s; animation-delay: .3s;">
        Sponsorship ends upon fulfillment of the budget. 
        The planned deadline is 15th November 2021  
    </p>
    <div class="row">
    <div class="col-md-4">
    <div class="pricing-table pricing-table-x">
    <div class="table-header">
    <h3>
        Gold
    </h3>
    </div>
    <div class="plan">
    <h3 class="price">
        60, 000, 000<span>Tsh</span>
    </h3>
    <span class="per">Number of sponsor spot = 1</span>
    </div>
    <div class="plan-info">
    <ul style="font-size: 11px;">
        <li>Naming rights of event tittle.</li>
        <li> Big tent exclusivity </li>
        <li> Logo on all print materials (Fliers, Posters, Billboard banners, tickets etc.), </li>
        <li> Logo on all visuals aids (Teasers, Promo &amp; TV commercials). </li>
        <li> Radio mention of sponsors on (Plus Media ,Clouds Media &amp; Azam Media) </li>
        <li> Sponsored Ad’s on social media platforms (Facebook, Instagram &amp; Twitter). </li>
        <li> Press conference day, bring in representative or company spokesperson
                along with promotional materials to place at the venue. </li>
        <li> Staff complimentary tickets (As token of appreciation to your staff in the
                company 50 max). </li>
        <li> Rights to conduct customer feedback on survey for your products of services to
                audiences. </li>
        <li> Logo on edited pictures of the event (Published online/blogs/social media
                pages). </li>
        <li> Event post wall be reposted on local celebrity in Tanzania over 2 - 4 Millions
                followers. </li>
        <li> Right to do sales on event day. </li>
        <li> Placement of stand Advert or Roadside 20 - 30 days before event day.</li>
    </ul>
    </div>
    <div class="button-area">
     <form class="shake contactForm"  action="{{ route('order_store')}}" method="post">
        @csrf
        <input type="hidden"  name="package_name" value="Gold Package">
        <input type="hidden"  name="package_amount" value="60000000">
        <button class="btn btn-common" type="submit" value="submit" name="submit">Order Now</button>
    </form>
   
    </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="pricing-table pricing-table-x active">
    <div class="table-header highlight">
    <h3>
        Silver
    </h3>
    </div>
    <div class="plan">
    <h3 class="price">
        30, 000, 000<span>Tsh</span>
    </h3>
    <span class="per">Number of sponsor spot = 2</span>
    </div>
    <div class="plan-info">
    <ul style="font-size: 11px;">
    
            <li> Tent (3x3) </li>
            <li> Logo on all print materials (Fliers, Posters, Billboard banners, tickets etc.), </li>
            <li> Logo on all visuals aids (Teasers, Promo &amp; TV commercials). </li>
            <li> Radio mention of sponsors on (Plus Media ,Clouds Media &amp; Azam Media) </li>
            <li> Sponsored Ad’s on social media platforms (Facebook, Instagram &amp; Twitter). </li>
            <li> Press conference day, bring in representative or company spokesperson
                    along with promotional materials to place at the venue. </li>
            <li> Staff complimentary tickets (As token of appreciation to your staff in the
                    company 25 max). </li>
            <li> Branding rights on event ground (Tear Drops, Roll Up Banners, etc). </li>
            <li> Rights to conduct customer feedback on survey for your products of services to
                    audiences. </li>
            <li> Event post wall be reposted local celebrity in Tanzania over 2 - 4 Millions followers. </li>
            <li> Right to do sales on event day.</li>
        </ul>
    </div>
    <div class="button-area">
        <form class="shake contactForm"  action="{{ route('order_store')}}" method="post">
            @csrf
            <input type="hidden"  name="package_name" value="Silver Package">
            <input type="hidden"  name="package_amount" value="30000000">
            <button class="btn btn-common" type="submit" value="submit" name="submit">Order Now</button>
        </form>
    </div>
    </div>
    </div>
    <div class="col-md-4 wow animated" style="visibility: visible;">
    <div class="pricing-table pricing-table-x">
    <div class="table-header">
    <h3>
        Bronze
    </h3>
    </div>
    <div class="plan">
    <h3 class="price">
        10, 000, 000<span>Tsh</span>
    </h3>
    <span class="per">Number of sponsor spot = 4</span>
    </div>
    <div class="plan-info">
        <ul style="font-size: 11px;">
            <li> Tent (3x3) </li>
            <li> Logo on all print materials (Fliers, Posters, Billboard banners, tickets etc.), </li>
            <li> Logo on all visuals aids (Teasers, Promo &amp; TV commercials). </li>
            <li> Radio mention of sponsors on (Plus Media ,Clouds Media &amp; Azam Media) </li>
            <li> Sponsored Ad’s on social media platforms (Facebook, Instagram &amp; Twitter). </li>
            <li> Press conference day, bring in representative or company spokesperson
                    along with promotional materials to place at the venue. </li>
            <li> Staff complimentary tickets (As token of appreciation to your staff in the
                    company 15 max). </li>
            <li> Rights to conduct customer feedback on survey for your products of services
                    audiences. </li>
            <li> Event post wall be reposted local celebrity in Tanzania over 2 - 4 Millions
                    followers. </li>
            <li> Right to do sales on event day.</li>
        </ul>
    </div>
    <div class="button-area">
        <form class="shake contactForm"  action="{{ route('order_store')}}" method="post">
            @csrf
            <input type="hidden"  name="package_name" value="Bronze Package">
            <input type="hidden"  name="package_amount" value="10000000">
            <button class="btn btn-common" type="submit" value="submit" name="submit">Order Now</button>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>
</section>