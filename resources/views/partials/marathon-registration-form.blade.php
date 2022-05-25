<section class="registration">
    <div class="container-fluid">
        <div class="row r-row" >
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 reg-inner-col">
                <h2 class="r-header" >Register For Marathon Now
                </h2>
                <form class="shake contactForm" action="{{ route('marathon_registration') }}" method="post">
                    @csrf
                    <input type="hidden" name="description" value="Kilimo Marathon Fee">
                    <input type="hidden" name="amount" value="35000">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="full_name" class="sr-only">Full Name</label>
                                <input type="text" placeholder="Full Name" id="full_name"
                                    class="form-control contact-control" name="full_name" required=""
                                    value="{{ old('full_name') }}">
                                <div class="help-block with-errors"></div>
                                @if ($errors->has('full_name'))
                                <span class="text-danger">{{ $errors->first('full_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email Address</label>
                                <input type="email" placeholder="Enter Email Address" id="email"
                                    class="form-control contact-control" name="email" required=""
                                    value="{{ old('email') }}">
                                <div class="help-block with-errors"></div>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="mobile" class="sr-only">Mobile</label>
                                <input type="tel" pattern="^\d{1}\d{9}$" placeholder="Mobile e.g: 0xxxxxxxxx"
                                    title=" Please match the required format 0xxxxxxxxx " id="phone"
                                    class="form-control contact-control" name="phone" required=""
                                    value="{{ old('phone') }}">
                                <div class="help-block with-errors"></div>
                                @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="region" class="sr-only">Region</label>
                                <input type="text" placeholder="Your region" id="region"
                                    class="form-control contact-control" name="region" required=""
                                    value="{{ old('region') }}">
                                <div class="help-block with-errors"></div>
                                @if ($errors->has('region'))
                                <span class="text-danger">{{ $errors->first('region') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select id="select-d30c" name="payment_option" class="form-control contact-control" required="" style="text-align: center;">
                            <option value="">-- Select Payment Option --</option>
                            @foreach ($payment_options as $items)
                                @if ( $items['terminalmnocountry'] == 'Tanzania')
                                @if ( $items['terminalmno'] == 'TIGOdebitMandate')
                                <option value="{{$items['terminalmno']}}"> Tigo Tanzania</option>
                                @endif
                                @if ( $items['terminalmno'] == 'Selcom_webPay')
                                <option value="{{$items['terminalmno']}}"> Vodacom Tanzania</option>
                                @endif
                                @if ( $items['terminalmno'] == 'Selcom_webPay_Airtel')
                                <option value="{{$items['terminalmno']}}"> Airtel Tanzania</option>
                                @endif
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <select id="select-d30c" name="event" class="form-control contact-control" required="" style="text-align: center;">
                            <option value="">-- Select Marathon Run Distance --</option>
                            <option value="21">21 Km - Tsh 35,000</option>
                            <option value="10">10 Km - Tsh 35,000</option>
                            <option value="5">5 Km - Tsh 35,000</option>
                        </select>
                    </div>
                    <div class="submit-btn">
                        <button class="btn btn-common btn-lg " type="submit" name='submit' value="submit"
                        style="pointer-events: all; cursor: pointer;"> Submit <i class="fa fa-envelope"></i></button>
                    </div>
                  

                </form>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
                <h2 class="r-header">Other Methods of Payment
                </h2>
                <div class="row inner-row">
                    <div class="col-md-6 alt-payment">
                        <div class="alt-payment-header">
                            <h2 class="">Lipa Na Tigo Pesa</h2>
                        </div>
                        <div class="alt-payment-logo">
                            <img src="{{ asset('imgs/tigo-pesa.png') }}" alt="Tigo Pesa Logo">
                        </div>
                        <div class="alt-payment-desc">
                            <ul>
                                <li>Piga <span >*150*01#</span></li>
                                <li>Chagua <span >5  "Lipia Bidhaa"</span></li>
                                <li>Chagua <span >1 "Lipa Kwa Tigo Pesa"</span></li>
                                <li>Ingiza Lipa Namba <span class="pay-highlight">5057285</span></li>
                                <li>Ingiza Kiasi <span >35,000/=</span></li>
                                <li>Ingiza  <span >Namba ya Siri</span> Kuthibithisha</li>
                                <li>Jina La Biashara <span >KILIMO MARATHON AWARDS AND EXPO</span></li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-md-6 alt-payment">
                        <div class="alt-payment-header">
                            <h2 class="">Lipa Kwa Mitandao Mingine</h2>
                        </div>
                        <div class="alt-payment-logo-all">
                            <img src="{{ asset('imgs/all payment.png') }}" alt="Tigo Pesa Logo">
                        </div>
                        <div class="alt-payment-desc">
                            <ul>
                                <li>Fungua Menu ya Huduma za Kifedha</li>
                                <li>Chagua <span >Tuma Pesa</span></li>
                                <li>Chagua <span >Kwenda Mitandao Mingine</span></li>
                                <li>Chagua <span >Tigo Pesa</span></li>
                                <li>Ingiza Namba <span class="pay-highlight">5057285</span></li>
                                <li>Ingiza Kiasi <span >35,000/=</span></li>
                                <li>Ingiza  <span >Namba ya Siri</span> Kuthibithisha</li>
                                <li>Jina La Biashara <span >KILIMO MARATHON AWARDS AND EXPO</span></li>
                            </ul>

                        </div>
                    </div>

                </div>
                <div class="payment-desc">
                    <p>
                        Mara baada ya kulipa utatuma ujumbe wa maandishi kupitia namba yetu ya WhatsApp <span>+255 624 222 211</span>
                    </p>
                    <p>Ujumbe ukiwa na Majina yako kamili, umbali utakao kimbia, mkoa ulioko, mwisho utaandika namba za uthibitisho za malipo(M-Pesa, Tigo Pesa n.k). Mfano <span>9BE96MJIGHL</span> </p>
                </div>
               
            </div>



        </div>
    </div>
</section>
