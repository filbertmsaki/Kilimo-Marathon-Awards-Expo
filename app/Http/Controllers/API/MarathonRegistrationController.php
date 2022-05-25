<?php

namespace App\Http\Controllers\API;


use App\Models\Payment\Dpo;
use Illuminate\Support\Str;
use App\Models\AwardNominee;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Models\Payment\PushPayment;
use App\Models\AwardMarathonSetting;
use App\Models\MarathonRegistration;
use App\Mail\MarathonRegistrationMail;
use App\Models\Vote;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\MarathonRegistrationResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ExpoRegistration;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Mail;
use App\Mail\AwardRegistrationMail;


class MarathonRegistrationController extends BaseController
{
    public function index()
    {
        $marathon_registration_list = MarathonRegistration::all();
        return $this->handleResponse(MarathonRegistrationResource::collection($marathon_registration_list), 'Marathon registration list have been retrieved!', Response::HTTP_OK);
    }
    public function registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'region' => 'required',
            'payment_option' => 'required',
            'phone' =>  ['required', 'max:13', 'unique:marathon_registrations'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'event' => 'required',
        ]);

        $award_settings = AwardMarathonSetting::get()->first();
        if ($award_settings != null) {
            $marathon_registration_date = $award_settings->marathon_registration_time_remain;
            $marathon_registration_status =  $award_settings->marathon_registration;
            $curDateTime = date("Y-m-d H:i:s");
            $D_Date = date("Y-m-d H:i:s", strtotime($marathon_registration_date));

            if ($D_Date < $curDateTime ||  $marathon_registration_status == '0') {
                if ($validator->fails()) {
                    return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
                }
                if (!$validator->fails()) {

                    $validator->errors()->add('marathon_registration', 'Sorry Marathon Registration start on 1 June 2022');
                    return $this->handleError($validator->errors()->first(), Response::HTTP_NOT_FOUND);
                }
            } else {


                if ($validator->fails()) {
                    return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
                }
                if ($request->payment_option == 'Tigo') {
                    $payment_options = 'TIGOdebitMandate';
                    $amount = 35000;
                }
                if ($request->payment_option == 'Vodacom') {
                    $payment_options = 'Selcom_webPay';
                    $amount = 35000;
                }
                if ($request->payment_option == 'Airtel') {
                    $payment_options = 'Selcom_webPay_Airtel';
                    $amount = 35000;
                }
                $trimedmobile = substr($request->phone, -9);
                $phonenumber = '255' . $trimedmobile;
                $full_name      = $params['full_name']         = $request->full_name;
                $region         = $params['region']            = $request->region;
                $payment_option = $params['payment_option']    = $payment_options;
                $phone          = $params['phone']             = $phonenumber;
                $email          = $params['email']             = $request->email;
                $event          = $params['event']             = $request->event;
                $amount         = $params['amount']            = $amount;
                $description    = $params['description']       = 'Marathon fee for ' . $request->event . ' run';

                $general_slug = Str::random(40);

                $i = 0;
                while (MarathonRegistration::where('slug', $general_slug)->exists()) {
                    $i++;
                    $general_slug = Str::random(39) . $i;
                }
                 $marathon_registration=MarathonRegistration::create([
                        'slug' =>$general_slug,
                        'full_name' => $full_name,
                        'region' => $region,
                        'phone' => $phone,
                        'email' => $email,
                        'event' => $event,
                        'paid' => 0,
                    ]
                ); 
                return $this->marathon_payment($params);
            }
        }
    }
    public function marathon_payment($params)
    {
        $data = [];
        $name = explode(" ", $params['full_name']);
        $data['customerFirstName'] = $name[0];
        $data['customerLastName'] = $name[1];
        $data['customerCity'] = $params['region'];
        $data['paymentOption'] = $params['payment_option'];
        $data['customerPhone'] = $params['phone'];
        $data['customerEmail'] =  $params['email'];
        $data['paymentAmount'] =  $params['amount'];
        $data['orderDescription'] =  $params['description'];
        $data['customerCountry'] = 'TZ';
        $data['customerZip'] = '0000';
        $data['companyRef'] = 'KME' . '' . time();

        $dpo = new Dpo();
        $tokens = $dpo->createToken($data);
        if ($tokens['success'] == true) {

            $chargeData = [];
            $chargeData['transToken'] = $tokens['result']['TransToken'];
            $chargeData['phoneNumber'] = $params['phone'];
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
                        'customerphone' => $params['phone'],
                        'transactionamount' => $params['amount'],
                        'transactiontoken' => $tokens['result']['TransToken'],
                        'status' => 'Not Paid',
                    ]);
                    return   $payment_details;
                    // return view('marathon_invoice')->with(['payment_details'=>$payment_details,'payment'=>$payment]);
                }
            }
        }
    }

    public function awards_registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:3|max:255',
            'mobile' => ['required', 'max:13', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'email' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'award_category' => ['required'],
        ]);
        $trimedmobile = substr($request->mobile, -9);
        $mobile = '255' . $trimedmobile;


        $award_settings = AwardMarathonSetting::get()->first();
        if ($award_settings != null) {

            $awards_registration_date = $award_settings->awards_registration_time_remain;
            $awards_registration_status =  $award_settings->awards_registration;
            $curDateTime = date("Y-m-d H:i:s");
            $D_Date = date("Y-m-d H:i:s", strtotime($awards_registration_date));

            if ($D_Date < $curDateTime ||  $awards_registration_status == '0') {
                if ($validator->fails()) {
                    return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
                }
                if (!$validator->fails()) {

                    $validator->errors()->add('award_registration', 'Sorry ' . $request->full_name . '. Award nominee registration is closed for now.');
                    return $this->handleError($validator->errors()->first(), Response::HTTP_NOT_FOUND);
                }
            } else {


                if ($validator->fails()) {
                    return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
                }

                if (!$validator->fails()) {
                    $award_category = AwardCategory::where('name', $request->award_category)->first();
                    if ($award_category == null) {
                        $validator->errors()->add('award_category', 'The award category does not exist.');
                        return $this->handleError($validator->errors()->first(), Response::HTTP_NOT_FOUND);
                    }
                    $award_category_id =  $award_category->id;
                }

                $general_slug = Str::random(40);

                $i = 0;
                while (AwardNominee::where('slug', $general_slug)->exists()) {
                    $i++;
                    $general_slug = Str::random(39) . $i;
                }
                if ($request->company_individual == 'Individual') {
                    $nominees = AwardNominee::create(
                        [
                            'slug'                  => $general_slug,
                            'full_name'             => $request->full_name,
                            'contact_person_name'   => $request->contact_person_name,
                            'mobile'                => $mobile,
                            'email'                 => $request->email,
                            'address'               => $request->address,
                            'company_details'       => $request->company_details,
                            'category_id'           => $award_category_id,
                            'company_individual'    => $request->company_individual,
                        ]
                    );
                } else {
                    $nominees = AwardNominee::create(
                        [
                            'slug'                  => $general_slug,
                            'full_name'             => $request->full_name,
                            'company_phone'         => $request->company_phone,
                            'company_email'         => $request->company_email,
                            'contact_person_name'   => $request->contact_person_name,
                            'mobile'                => $mobile,
                            'email'                 => $request->email,
                            'address'               => $request->address,
                            'company_details'       => $request->company_details,
                            'category_id'           => $award_category_id,
                            'company_individual'    => $request->company_individual,
                        ]
                    );
                }
                if ($nominees) {
                    $maildata = [
                        'email' => $request->email,
                        'subject' => 'Kilimo Awards Nominee Form',
                    ];
                    $mail = new AwardRegistrationMail($maildata);
                    Mail::send($mail);
                }


                return $this->handleResponse('Congratulation ' . $request->full_name . '!. You have been successfully registered to Kilimo Awards Nominee', Response::HTTP_CREATED);
            }
        }
    }
    public function sponsorship_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'contact_person_name' => 'required',
            'contact_person_email' => 'required',
            'contact_person_phone' =>  ['required',],
            'contact_person_address' => ['required',],
            'company_details' => 'required',
            'sponsorship_category' => 'required',
        ]);
        $trimedmobile = substr($request->contact_person_phone, -9);
        $contact_person_phone = '255' . $trimedmobile;

        if ($validator->fails()) {
            return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $general_slug = Str::random(40);

        $i = 0;
        while (Sponsorship::where('slug', $general_slug)->exists()) {
            $i++;
            $general_slug = Str::random(39) . $i;
        }

        $sponsorship = Sponsorship::create([
            'slug' => $general_slug,
            'company_name' => $request->company_name,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_email' => $request->contact_person_email,
            'contact_person_phone' =>  $contact_person_phone,
            'contact_person_address' => $request->contact_person_address,
            'company_details' => $request->company_details,
            'sponsorship_category' => $request->sponsorship_category,

        ]);
        return $this->handleResponse('Congratulation ' . $request->contact_person_name . '!. You are sponsorship request received!', Response::HTTP_CREATED);
    }
    public function expo_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'contact_person_name' => 'required',
            'contact_person_email' => 'required',
            'contact_person_phone' =>  ['required',],
            'business_details' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $general_slug = Str::random(40);

        $i = 0;
        while (Sponsorship::where('slug', $general_slug)->exists()) {
            $i++;
            $general_slug = Str::random(39) . $i;
        }

        $exporegistration = ExpoRegistration::create([
            'slug' => $general_slug,
            'company_name' => $request->company_name,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_email' => $request->contact_person_email,
            'contact_person_phone' =>  $request->contact_person_phone,
            'business_details' => $request->business_details,

        ]);
        return $this->handleResponse('Congratulation ' . $request->contact_person_name . '!. You have been successfully registered to Kilimo Expo!', Response::HTTP_CREATED);
    }
    public function award_vote_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'award_category_name' => 'required',
            'nominee_name' => 'required',
        ]);
        $award_settings = AwardMarathonSetting::get()->first();
        if ($award_settings != null) {
            $voting_date = $award_settings->vote_time_remain;
            $voting_status =  $award_settings->vote;
            $curDateTime = date("Y-m-d H:i:s");
            $D_Date = date("Y-m-d H:i:s", strtotime($voting_date));

            if ($D_Date < $curDateTime ||  $voting_status == '0') {
                if ($validator->fails()) {
                    return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
                }
                if (!$validator->fails()) {

                    $validator->errors()->add('vote_time', 'Sorry awards voting start on 1 July 2022');
                    return $this->handleError($validator->errors()->first(), Response::HTTP_NOT_FOUND);
                }
            } else {

                if ($validator->fails()) {
                    return $this->handleError($validator->errors(), Response::HTTP_BAD_REQUEST);
                }
                if (!$validator->fails()) {
                    $award_category = AwardCategory::where('name', $request->award_category_name)->first();
                    if ($award_category == null) {
                        $validator->errors()->add('award_category', 'The award category does not exist.');
                        return $this->handleError($validator->errors()->first(), Response::HTTP_NOT_FOUND);
                    }
                    $award_category_id =  $award_category->id;
                }
                if (!$validator->fails()) {
                    $award_nominee = AwardNominee::where('full_name', $request->nominee_name)
                        ->where('category_id', $award_category_id)->first();
                    if ($award_nominee == null) {
                        $validator->errors()->add('award_nominee', 'Award nominee does not exist.');
                        return $this->handleError($validator->errors()->first(), Response::HTTP_NOT_FOUND);
                    }
                    $award_nominee_id =  $award_nominee->id;
                }

                $category_id = $award_category_id;
                $nominee_id = $award_nominee_id;
                $ip =  $request->getClientIp();
                $nominee_vote = AwardNominee::where('id', $nominee_id)->first();
                $award_category = AwardCategory::where('id', $category_id)->first();
                $voted = Vote::where(
                    'ip',
                    $ip
                )
                    ->where('category_id', $category_id)
                    ->first();
                if ($voted == null) {
                    if ($nominee_vote->vote == null) {
                        $addvote = 1;
                    } else {
                        $addvote = $nominee_vote->vote + 1;
                    }
                    $nominees = AwardNominee::where('id', $nominee_id)
                        ->where('category_id', $category_id)
                        ->update(['vote' => $addvote,]);

                    Vote::create([
                        'ip' => $ip,
                        'nominee_id' => $nominee_id,
                        'category_id' => $category_id,
                    ]);
                    return $this->handleResponse('You  have voted for ' . $nominee_vote->full_name . ' as ' . $award_category->name, Response::HTTP_CREATED);
                } else {
                    $nominee_voted = AwardNominee::where('id', $voted->nominee_id)->first();
                    return $this->handleResponse('You  have already voted for ' . $nominee_voted->full_name . ' in this category', Response::HTTP_NOT_FOUND);
                }
            }
        }
    }
}
