<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vote;
use App\Models\Gallery;
use Jorenvh\Share\Share;
use App\Models\ContactUs;
use App\Models\Subscriber;
use App\Mail\SubscribeMail;
use App\Models\Payment\Dpo;
use Illuminate\Support\Str;
use App\Models\AwardNominee;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Models\Payment\DpoGroup;
use Illuminate\Support\Facades\DB;
use App\Mail\AwardRegistrationMail;
use App\Models\Payment\PushPayment;
use App\Models\AwardMarathonSetting;
use App\Models\MarathonRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function getBalance()
    {
        $dpo = new Dpo();
        $verified = $dpo->getBalance();
        //refund token
        $data['transToken'] = '679ADB95-8BD9-4163-A089-A0D0438DC547';
        $data['refundAmount'] = '';
        $data['refundDetails'] = '';
        // $verified = $dpo->refundToken($data);
        // $verified = $dpo->cancelToken($data);

        $dpo = new Dpo();
        $payment_options = $dpo->companyMobilePaymentOptions();
        $data = $payment_options['result'];
        dd($data);
        return $verified;
    }
    public function verify_payment()
    {
        $row_payment_settings = DpoGroup::first();
        $dpo_company_token      = $row_payment_settings->dpo_company_token;
        $pushpayments = PushPayment::where('status', '!=', 'Paid')->get();
        foreach ($pushpayments as $pay) {
            $payments = PushPayment::where('slug', $pay->slug)->first();
            $transToken = $pay->transactiontoken;
            $data = [];
            $data['companyToken'] = $dpo_company_token;
            $data['transToken'] = $transToken;
            $dpo = new Dpo();
            $verified = $dpo->verifyToken($data);
            $token = $verified['result'];
            $result = $token['Result'];
            $resultexplanation = $token['ResultExplanation'];
            if ($result == 000) {
                //Paid
                //send SMS to user after complete payment
                $trimedmobile = substr($token['CustomerPhone'], -9);
                $phonenumber = '255' . $trimedmobile;
                $base_url = 'https://messaging-service.co.tz/api/sms/v1/text/single';
                $from = 'SHAMBADUNIA';
                $to = $phonenumber;
                $text = 'Habari ' . $token['CustomerName'] . ' malipo yako ya TZS ' . $token['TransactionAmount'] . ' kwa ajili ya kushiriki kwenye KILIMO MARATHON yamekamilika.Risiti Namba ' . $token['TransactionApproval'] . '. Kwa msaada zaidi piga simu :+255754222800.';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $base_url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{"from":"' . $from . '", "to":"' . $to . '",  "text": "' . $text . '"}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic c2hhbWJhZHVuaWE6UFY5Qzk1',
                        'Content-Type: application/json',
                        'Accept: application/json'
                    ),
                ));
                $response = curl_exec($curl);
                $error    = curl_error($curl);
                $datafile = json_decode($response, true, JSON_UNESCAPED_SLASHES);;
                curl_close($curl);
                ///////////////////////////////////////////////////////////////////////
                $payments->update([
                    'result' => $result,
                    'resultexplanation' => $resultexplanation,
                    'customername' => $token['CustomerName'],
                    'customercredit' => $token['CustomerCredit'],
                    'customercredittype' => $token['CustomerCreditType'],
                    'transactionapproval' => $token['TransactionApproval'],
                    'transactioncurrency' => $token['TransactionCurrency'],
                    'transactionamount' => $token['TransactionAmount'],
                    'fraudalert' => $token['FraudAlert'],
                    'fraudexplnation' => $token['FraudExplnation'],
                    'transactionnetamount' => $token['TransactionNetAmount'],
                    'transactionsettlementdate' => $token['TransactionSettlementDate'],
                    'transactionrollingreserveamount' => $token['TransactionRollingReserveAmount'],
                    'transactionrollingreservedate' => $token['TransactionRollingReserveDate'],
                    'transactionfinalcurrency' => $token['TransactionFinalCurrency'],
                    'transactionfinalamount' => $token['TransactionFinalAmount'],
                    'customerphone' => $token['CustomerPhone'],
                    'customercountry' => $token['CustomerCountry'],
                    'customercity' => $token['CustomerCity'],
                    'customerzip' => $token['CustomerZip'],
                    'mobilepaymentrequest' => $token['MobilePaymentRequest'],
                    'accref' => $token['AccRef'],
                    'status' => 'Paid',
                ]);
            } else {
                $payments->update([
                    'result' => $result,
                    'resultexplanation' => $resultexplanation,
                    'customername' => $token['CustomerName'],
                    'customercredit' => $token['CustomerCredit'],
                    'customercredittype' => $token['CustomerCreditType'],
                    'transactionapproval' => $token['TransactionApproval'],
                    'transactioncurrency' => $token['TransactionCurrency'],
                    'transactionamount' => $token['TransactionAmount'],
                    'fraudalert' => $token['FraudAlert'],
                    'fraudexplnation' => $token['FraudExplnation'],
                    'transactionnetamount' => $token['TransactionNetAmount'],
                    'transactionsettlementdate' => $token['TransactionSettlementDate'],
                    'transactionrollingreserveamount' => $token['TransactionRollingReserveAmount'],
                    'transactionrollingreservedate' => $token['TransactionRollingReserveDate'],
                    'transactionfinalcurrency' => $token['TransactionFinalCurrency'],
                    'transactionfinalamount' => $token['TransactionFinalAmount'],
                    'customerphone' => $token['CustomerPhone'],
                    'customercountry' => $token['CustomerCountry'],
                    'customercity' => $token['CustomerCity'],
                    'customerzip' => $token['CustomerZip'],
                    'mobilepaymentrequest' => $token['MobilePaymentRequest'],
                    'accref' => $token['AccRef'],
                    'status' => 'Not Paid',
                ]);
            }
        }
    }
    public function index()
    {
        return view('index');
    }
    public function about()
    {
        return view('about');
    }
    public function sponsorship()
    {
        return view('sponsorship');
    }
    public function sponsorship_packages()
    {
        return view('sponsorship_package');
    }
    public function registration()
    {
        $dpo = new Dpo();
        $payment_options = $dpo->companyMobilePaymentOptions();
        $data = $payment_options['result'];
        return view('registration')->with('payment_options', $data);
    }
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        $email = $request->all()['email'];
        if ($validator->fails()) {
            $existemail = Subscriber::where(['email' => $email])->first();
            if (!empty($existemail)) {
                $validator->errors()->add('email', 'The email already subscribe to our newsletter.');
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (!$validator->fails()) {
            $existemail = Subscriber::where(['email' => $email])->first();
            if ($existemail !== null) {
                $validator->errors()->add('email', 'The email already subscribe to our newsletter.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $subscriber = Subscriber::create(
            [
                'email' => $email
            ]
        );
        $maildata = [
            'email' => $email,
            'subject' => 'Thank for subscribing to Kilimo Marathon, Awards & EXPO',
        ];
        $mail = new SubscribeMail($maildata);
        Mail::send($mail);
        return redirect()->back()->with('success', 'Thank you for subscribing to our email, please check your inbox');
    }
    public function marathon_registration(Request $request)
    {
        $award_settings = AwardMarathonSetting::get()->first();
        $marathon_registration_date = $award_settings->marathon_registration_time_remain;
        $marathon_registration_status =  $award_settings->marathon_registration;
        $curDateTime = date("Y-m-d H:i:s");
        $D_Date = date("Y-m-d H:i:s", strtotime($marathon_registration_date));
        if ($D_Date < $curDateTime ||  $marathon_registration_status == '0') {
            return redirect()->back()->with('warning', 'Ooops...Marathon Registration start on 1 June 2022');
        } else {
            $request->validate([
                'full_name' => 'required',
                'region' => 'required',
                'phone' =>  ['required', 'max:13', 'unique:marathon_registrations'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:marathon_registrations'],
                'event' => 'required',
            ]);
            if ($request->amount != 35000) {
                return redirect()->back()->with('danger', 'Registration Fail Due to Payment Error !');
            }
            $trimedmobile = substr($request->phone, -9);
            $phonenumber = '255' . $trimedmobile;
            $full_name     = $params['full_name']          = $request->full_name;
            $region           = $params['region']          = $request->region;
            $city           = $params['city']              = $request->region;
            $phone         = $params['mobile']             = $phonenumber;
            $email          = $params['email']             = $request->email;
            $amount         = $params['amount']            = 35000;
            $description    = $params['description']       = $request->description;
            // $payment_option    = $params['payment_option']       = $request->payment_option;
            $event    = $params['event']       = $request->event;
            $general_slug = Str::random(40);
            $i = 0;
            while (MarathonRegistration::where('slug', $general_slug)->exists()) {
                $i++;
                $general_slug = Str::random(39) . $i;
            }
            $marathon = MarathonRegistration::create(
                [
                    'slug' => $general_slug,
                    'full_name' => $full_name,
                    'region' => $region,
                    'phone' => $phone,
                    'email' => $email,
                    'event' => $event,
                    'paid' => 0,
                ]
            );
            return $this->payment($params);
            // return redirect()->back()->with('success','Registration successfully!');
        }
    }
    public function registration_invoice()
    {
        return view('marathon_invoice');
    }
    public function marathon_payment($params)
    {
        $data = [];
        $name = explode(" ", $params['full_name']);
        $data['paymentAmount'] =  $params['amount'];
        $data['customerFirstName'] = $name[0];
        $data['customerLastName'] = $name[1];
        $data['customerCity'] = $params['city'];
        $data['customerPhone'] = $params['mobile'];
        $data['customerEmail'] =  $params['email'];
        $data['customerCountry'] = 'TZ';
        $data['customerZip'] = '0000';
        $data['companyRef'] = 'KME' . '' . time(); //$params['invoiceid']; (On this line you can put uniq id of your service)
        $data['orderDescription'] =  $params['description'];
        $dpo = new Dpo();
        $tokens = $dpo->createToken($data);
        if ($tokens['success'] === true) {
            $chargeData = [];
            $chargeData['transToken'] = $tokens['result']['TransToken'];
            $chargeData['phoneNumber'] = $params['mobile'];
            $chargeData['mno'] = $params['payment_option'];
            $chargeData['mnocountry'] = 'Tanzania';
            $mobilePay = $dpo->ChargeTokenMobile($chargeData);
            if (!empty($mobilePay) && $mobilePay != '') {
                if ($mobilePay['success'] = true) {
                    $payment_details = $mobilePay['result'];
                    // Save the transaction reference
                    $slug = Str::random(40);
                    $i = 0;
                    $i = 0;
                    while (PushPayment::where('slug', $slug)->exists()) {
                        $i++;
                        $slug = Str::random(40) . $i;
                    }
                    $payment = PushPayment::create([
                        'slug' => $slug,
                        'transactionref' => $data['companyRef'],
                        'customerphone' => $params['mobile'],
                        'transactionamount' => $params['amount'],
                        'transactiontoken' => $tokens['result']['TransToken'],
                        'status' => 'Not Paid',
                    ]);
                    //    return   $payment_details['instructions'];
                    return view('marathon_invoice')->with(['payment_details' => $payment_details, 'payment' => $payment]);
                }
            }
        }
    }
    public function refund_policy()
    {
        return view('refund-policy');
    }
    public function contact_us()
    {
        return view('contact-us');
    }
    public function contact_us_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' =>  ['required', 'max:13', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'message' => 'required',
        ]);
        $email = $request->email;
        $name = $request->name;
        $phone = $request->phone;
        $message = $request->message;
        ContactUs::create(
            [
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'message' => $message,
            ]
        );
        return redirect()->back()->with('success', 'Thank you for Contact Us ');
    }
    public function package_order_view()
    {
        return view('order');
    }
    public function order_store(Request $request)
    {
        $id = 1;
        $data = session()->get('data');
        // if data is empty then this the first product
        if ($data) {
            Session::forget('data');
        }
        $data = [
            $id => [
                "package" =>  $request->package_name,
                "amount" => $request->package_amount,
            ]
        ];
        session()->put('data', $data);
        return redirect()->route('package_order_view');
    }
    public function package_payment(Request $request)
    {
        if ($request->amount == "1000000" || $request->amount == "500000") {
            $full_name      = $params['full_name']         = $request->full_name;
            $city           = $params['city']              = $request->region;
            $mobile         = $params['mobile']            = $request->mobile;
            $email          = $params['email']             = $request->email;
            $amount         = $params['amount']            = $request->amount;
            $description    = $params['description']       = $request->description;
            return $this->payment($params);
        } else {
            return redirect()->back()->with('danger', 'Package Payment Fail Due to Payment Error !');
        }
    }
    public function profile()
    {
        $nominee = AwardNominee::where('')->first();
        $award_category = AwardCategory::all();
        return view('profile')->with(['award_category' => $award_category, 'nominee' => $nominee]);
    }
    public function order()
    {
        return view('order');
    }
    public function payment($params)
    {
        $data = [];
        $name = explode(" ", $params['full_name']);
        $data['paymentAmount'] =  $params['amount'];
        $data['customerFirstName'] = $name[0];
        $data['customerLastName'] = $name[1];
        $data['customerCity'] = $params['city'];
        $data['customerPhone'] = $params['mobile'];
        $data['customerEmail'] =  $params['email'];
        $data['customerCountry'] = 'TZ';
        $data['customerZip'] = '0000';
        $data['companyRef'] = 'KME' . '' . time(); //$params['invoiceid']; (On this line you can put uniq id of your service)
        $data['orderDescription'] =  $params['description'];
        $dpo = new Dpo();
        $tokens = $dpo->createToken($data);
        if ($tokens['success'] === true) {
            $data['transToken'] = $tokens['result']['TransToken'];
            $verify = $dpo->verifyToken($data);
            if (!empty($verify) && $verify != '') {
                if ($verify['result']['Result'] === '900') {
                    $payment_url = $dpo->getPaymentUrl($tokens);
                    // Save the transaction reference
                    $slug = Str::random(40);
                    $i = 0;
                    $i = 0;
                    while (PushPayment::where('slug', $slug)->exists()) {
                        $i++;
                        $slug = Str::random(40) . $i;
                    }
                    $payment = PushPayment::create([
                        'slug' => $slug,
                        'transactionref' => $data['companyRef'],
                        'customerphone' => $data['customerPhone'],
                        'transactionamount' => $data['paymentAmount'],
                        'transactiontoken' => $data['transToken'],
                        'status' => 'pending',
                    ]);
                    return Redirect::to($payment_url);
                }
            }
        }
    }
    public function awards()
    {
        $award_category = AwardCategory::all();
        $award_settings = AwardMarathonSetting::get()->first();
        return view('award.index')->with(['award_category' => $award_category, 'award_settings' => $award_settings]);
    }
    public function awards_criteria($slug)
    {
        $award_settings = AwardMarathonSetting::get()->first();
        if (AwardCategory::where('slug', $slug)->exists()) {
            $award_category = AwardCategory::where('slug', $slug)->first();
            return view('award.award-criteria')->with(['award_category' => $award_category, 'award_settings' => $award_settings]);
        } else {
            $award_category = AwardCategory::all();
            return redirect()->route('awards')->with(['award_category' => $award_category, 'award_settings' => $award_settings]);
        }
    }
    public function awards_nominees()
    {
        $award_category = AwardCategory::all();
        return view('award.nominees')->with(['award_category' => $award_category]);
    }
    public function awards_nominees_store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|min:3|max:255',
            'mobile' => ['required', 'max:12', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'email' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'award_category' => ['required'],
        ]);
        $general_slug = Str::random(40);
        $i = 0;
        while (AwardNominee::where('slug', $general_slug)->exists()) {
            $i++;
            $general_slug = Hash::make(Str::random(40) . $i);
        }
        $nominees = AwardNominee::create(
            [
                'slug' => $general_slug,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'category_id' => $request->award_category,
                'full_name' => $request->full_name,
                'company_individual' => $request->company_individual,
                'verified' => 0,
            ]
        );
        if ($nominees) {
            $maildata = [
                'email' => $request->email,
                'subject' => 'Kilimo Awards Nominee Form',
            ];
            $mail = new AwardRegistrationMail($maildata);
            Mail::send($mail);
        }
        return redirect()->route('index')->with('success', 'Registration Sucessfull !');
    }
    public function gallery_2021()
    {
        $gallery = Gallery::all();
        return view('gallery_2021')->with(['gallery' => $gallery]);
    }
    public function votes()
    {
        $award_settings = AwardMarathonSetting::get()->first();
        $voting_date = $award_settings->vote_time_remain;
        $vote_status =  $award_settings->vote;
        $curDateTime = date("Y-m-d H:i:s");
        $D_Date = date("Y-m-d H:i:s", strtotime($voting_date));
        if ($D_Date < $curDateTime ||  $vote_status == '0') {
            return view('award.time-out');
        } else {
            $currrentYear = date('Y');
            $groupedNominees = AwardNominee::with('awardcategory')
                ->where('Verified', '=', '1')
                ->whereYear('created_at', '=', $currrentYear)
                ->groupBy('category_id')
                ->orderBy(DB::raw('COUNT(id)', 'asc'))
                ->get(array(DB::raw('COUNT(id) as total_nominee'), 'category_id'));
            return view('award.award-category')->with(['nominees' => $groupedNominees]);
        }
    }
    public function votes_nominees($id)
    {
        $award_settings = AwardMarathonSetting::get()->first();
        $voting_date = $award_settings->vote_time_remain;
        $vote_status =  $award_settings->vote;
        $curDateTime = date("Y-m-d H:i:s");
        $D_Date = date("Y-m-d H:i:s", strtotime($voting_date));
        if ($D_Date < $curDateTime ||  $vote_status == '0') {
            return view('award.time-out');
        } else {
            $currrentYear = date('Y');
            $award_category = AwardCategory::where('slug', $id)->latest()->first();
            $award_nominees = AwardNominee::with('awardcategory')
                ->where('Verified', '=', '1')
                ->where('category_id', '=', $award_category->id)
                ->whereYear('created_at', '=', $currrentYear)
                ->orderBy('id', 'asc')
                ->get();
            $share = new Share();
            $share->currentPage('Please vote for me as a ' . '' . $award_category->name)
                ->facebook()
                ->twitter()
                ->linkedin()
                ->whatsapp();
            return view('award.award-category-nominee')->with(['share' => $share, 'award_category' => $award_category, 'award_nominees' => $award_nominees]);
        }
    }
    public function awards_vote_store(Request $request)
    {
        $category_id = $request->category_id;
        $nominee_id = $request->nominee_id;
        $ip =  $request->getClientIp();
        $nominee_vote = AwardNominee::where('id', $request->nominee_id)->first();
        $award_category = AwardCategory::where('id', $category_id)->first();
        $voted = Vote::where([
            'ip' => $ip,
            'category_id' => $category_id
        ])->first();
        if ($voted == null) {
            if ($nominee_vote->vote == null) {
                $addvote = 1;
            } else {
                $addvote = $nominee_vote->vote + 1;
            }
            AwardNominee::updateOrCreate([
                'id' => $request->nominee_id,
            ], [
                'vote' => $addvote,
            ]);
            Vote::create([
                'ip' => $ip,
                'nominee_id' => $nominee_id,
                'category_id' => $category_id,
            ]);
            return redirect()->back()->with('success', 'You  have voted for ' . $nominee_vote->full_name . ' as ' . $award_category->name);
            // return response()->json(['success'=>'You  have voted for '.$vote->full_name.' as '.$award_category->first()->name, 200]);
        } else {
            $category_id_voted = $voted->category_id;
            $nominee_id_voted = $voted->nominee_id;
            $nominee_voted = AwardNominee::where('id', $nominee_id_voted)->first();
            $award_category_voter = AwardCategory::where('id', $nominee_id_voted)->first();
            return redirect()->back()->with('warning', 'You  have already voted for ' . $nominee_voted->full_name . ' in this category');
        }
    }
    public function callback(Request $request)
    {
        $transactionref = $request->CompanyRef;
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;
        $check_transaction = PushPayment::where('transactionref', $transactionref)->first();
        if ($check_transaction != null) {
            $check_transaction->update([
                'transactionref'        => $transactionref,
                'transactionapproval'   => $transactionapproval,
                'transactiontoken'      => $transactiontoken,
                'status'                => 'Paid',
                'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            // go back to orders or proposals or features
        } else {
            // insert new record and mark it flagged
            $slug = Str::random(40);
            $i = 0;
            $i = 0;
            while (PushPayment::where('slug', $slug)->exists()) {
                $i++;
                $slug = Str::random(40) . $i;
            }
            $payment = PushPayment::create([
                'slug'                  => $slug,
                'transactionref'        => $transactionref,
                'transactionapproval'   => $transactionapproval,
                'transactiontoken'      => $transactiontoken,
                'status'                => 'Flagged',
            ]);
            // go back to orders or proposals or features
        }
        return redirect()->route('index')->with('success', 'Payment Done');
    }
    public function canceled(Request $request)
    {
        $transactionref = $request->CompanyRef;
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;
        $check_transaction = PushPayment::where('transactionref', $transactionref)->first();
        if ($check_transaction != null) {
            $check_transaction->update([
                'transactionref'        => $transactionref,
                'transactionapproval'   => $transactionapproval,
                'transactiontoken'      => $transactiontoken,
                'status'             => 'Canceled',
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            // go back to orders or proposals or features
        } else {
            // insert new record and mark it flagged
            $slug = Str::random(40);
            $i = 0;
            $i = 0;
            while (PushPayment::where('slug', $slug)->exists()) {
                $i++;
                $slug = Str::random(40) . $i;
            }
            $payment = PushPayment::create([
                'slug'                  => $slug,
                'transactionref'        => $transactionref,
                'transactionapproval'   => $transactionapproval,
                'transactiontoken'      => $transactiontoken,
                'status'                => 'Flagged',
            ]);
            // go back to orders or proposals or features
        }
        return redirect()->route('index')->with('danger', 'Payment Canceled');
    }
    public function declined(Request $request)
    {
        $transactionref = $request->CompanyRef;
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;
        $check_transaction = PushPayment::where('transactionref', $transactionref)->first();
        if ($check_transaction != null) {
            $check_transaction->update([
                'transactionref'        => $transactionref,
                'transactionapproval'   => $transactionapproval,
                'transactiontoken'      => $transactiontoken,
                'status'             => 'Declined',
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            // go back to orders or proposals or features
        } else {
            // insert new record and mark it flagged
            $slug = Str::random(40);
            $i = 0;
            $i = 0;
            while (PushPayment::where('slug', $slug)->exists()) {
                $i++;
                $slug = Str::random(40) . $i;
            }
            $payment = PushPayment::create([
                'slug'                  => $slug,
                'transactionref'        => $transactionref,
                'transactionapproval'   => $transactionapproval,
                'transactiontoken'      => $transactiontoken,
                'status'                => 'Flagged',
            ]);
            // go back to orders or proposals or features
        }
        return redirect()->route('index')->with('warning', 'Payment Declined');
    }
}
