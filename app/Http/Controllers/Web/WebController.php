<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SubscribeMail;
use App\Models\AgriTourism;
use App\Models\AwardNominee;
use App\Models\ContactUs;
use App\Models\ExpoRegistration;
use App\Models\Gallery;
use App\Models\MarathonRegistration;
use App\Models\Partner;
use App\Models\Payment\Dpo;
use App\Models\Payment\FlutterwaveModel;
use App\Models\Payment\PushPayment;
use App\Models\Subscriber;
use App\Services\FlutterwaveService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Swift_TransportException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Return_;

class WebController extends Controller
{
    public function migrateAndSeed(Request $request)
    {
        // Call the migrate command and capture the output
        Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = Artisan::output();

        // Combine both outputs
        $output = $migrateOutput;

        return response()->json(['message' => 'Database migration and seeding completed successfully.', 'output' => $output]);
    }
    public function nominees()
    {

        // Fetch all nominees created in the year 2022
        $nominees2022 = AwardNominee::whereYear('created_at', 2022)->get();
        foreach ($nominees2022 as $nominee) {
            // Check if a record with the same company_name and contact_person_phone exists for the current year
            $exists = AwardNominee::where('company_name', $nominee->company_name)
                ->where('service_name', $nominee->service_name)
                ->where('contact_person_phone', $nominee->contact_person_phone)
                ->whereYear('created_at', now()->year)
                ->exists();

            if (!$exists) {
                // Duplicate the nominee data and adjust the timestamps
                $new =  AwardNominee::create([
                    'category_id' => $nominee->category_id,
                    'entry' => $nominee->entry,
                    'company_name' => $nominee->company_name,
                    'service_name' => $nominee->service_name,
                    'company_phone' => $nominee->company_phone,
                    'company_email' => $nominee->company_email,
                    'contact_person_name' => $nominee->contact_person_name,
                    'phonecode' => $nominee->phonecode,
                    'contact_person_phone' => $nominee->contact_person_phone,
                    'contact_person_email' => $nominee->contact_person_email,
                    'address' => $nominee->address,
                    'company_individual' => $nominee->company_individual,
                    'company_details' => $nominee->company_details,
                    'verified' => $nominee->verified,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return "Nominee data from 2022 successfully duplicated for the current year.";
    }
    public function flw_callback(Request $request)
    {
        // Extracting data from the request
        $transaction_id = $request->input('data.id');
        $txRef = $request->input('data.tx_ref');
        $status = $request->input('data.status');
        $flwRef = $request->input('data.flw_ref');
        $chargedAmount = $request->input('data.charged_amount');
        $currency = $request->input('data.currency');
        $device_fingerprint = $request->input('data.device_fingerprint');
        $app_fee = $request->input('data.app_fee');
        $app_fee = $request->input('data.app_fee');
        $merchant_fee = $request->input('data.merchant_fee');
        $processor_response = $request->input('data.processor_response');
        $auth_model = $request->input('data.auth_model');
        $ip = $request->input('data.ip');
        $narration = $request->input('data.narration');
        $payment_type = $request->input('data.payment_type');
        $payent_created_at = $request->input('data.created_at');
        $card_first_6digits = $request->input('data.card.first_6digits');
        $card_last_4digits = $request->input('data.card.last_4digits');
        $card_issuer = $request->input('data.card.issuer');
        $card_country = $request->input('data.card.country');
        $card_type = $request->input('data.card.type');
        $card_expiry = $request->input('data.card.expiry');
        // Find the Flutterwave record
        $flutterwaveData = FlutterwaveModel::where('reference', $txRef)->where('status', '!=', 'paid')->first();
        if (!$flutterwaveData) {
            return response()->json(['status' => 'error', 'message' => 'Transaction reference not found or already processed']);
        }
        if ($status !== 'successful') {
            return response()->json(['status' => 'error', 'message' => 'Payment status is not successful']);
        }
        if ($currency !== $flutterwaveData->currency) {
            return response()->json(['status' => 'error', 'message' => 'Currency does not match']);
        }
        if ($chargedAmount < $flutterwaveData->amount) {
            return response()->json(['status' => 'error', 'message' => 'Amount is less than expected']);
        }
        // Update the record with callback data
        $flutterwaveData->update([
            'charged_amount' => $chargedAmount,
            'charged_currency' => $currency,
            'transaction_id' => $transaction_id,
            'status' => 'paid',
            'flw_reference' => $flwRef,
            'device_fingerprint' => $device_fingerprint,
            'app_fee' => $app_fee,
            'merchant_fee' => $merchant_fee,
            'processor_response' => $processor_response,
            'auth_model' => $auth_model,
            'ip' => $ip,
            'narration' => $narration,
            'payment_type' => $payment_type,
            'payent_created_at' => $payent_created_at,
            'card_first_6digits' => $card_first_6digits,
            'card_last_4digits' => $card_last_4digits,
            'card_issuer' => $card_issuer,
            'card_country' => $card_country,
            'card_type' => $card_type,
            'card_expiry' => $card_expiry,
        ]);
        // Find and update the marathon registration
        $marathon = MarathonRegistration::where('reference', $txRef)->first();
        if ($marathon) {
            $marathon->update([
                'paid' => 1
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Callback received successfully.']);
    }

    public function flw_redirect(Request $request)
    {
        // Extract parameters from the request
        $status = $request->input('status');
        $txRef = $request->input('tx_ref');
        $transactionId = $request->input('transaction_id');
        // Find the record by reference (tx_ref)
        $flutterwaveData = FlutterwaveModel::where('reference', $txRef)
            // ->where('status', 'pending')
            ->first();
        if (!$flutterwaveData) {
            return view('web.payment.status', [
                'status' => 'error',
                'message' => 'Transaction reference not found'
            ]);
        }

        if ($status === 'successful') {
            $flutterwaveData->update([
                'payment_status' => 'success',
                'transaction_id' => $transactionId
            ]);

            // Return the success view
            return view('web.payment.status', [
                'status' => 'successful',
                'reference' => $txRef,
                'transaction_id' => $transactionId,
                'registration' => $flutterwaveData
            ]);
        } elseif ($status === 'cancelled') {
            $flutterwaveData->update([
                'payment_status' => 'cancelled'
            ]);

            // Return the cancelled view
            return view('web.payment.status', [
                'status' => 'cancelled',
                'reference' => $txRef,
                'transaction_id' => $transactionId,
                'registration' => $flutterwaveData
            ]);
        } else {
            // Handle other statuses
            $flutterwaveData->update([
                'payment_status' => 'failed'
            ]);
            return view('web.payment.status', [
                'status' => 'failed',
                'reference' => $txRef,
                'transaction_id' => $transactionId,
                'registration' => $flutterwaveData
            ]);
        }
    }

    public function index()
    {
        $partners = Partner::select('image_url')->orderBy('order', 'ASC')->get();
        return view('web.index', compact('partners'));
    }
    public function aboutUs()
    {
        return view('web.about-us');
    }
    public function sponsorship()
    {
        return view('web.sponsorship');
    }
    public function contactUs()
    {
        return view('web.contact-us');
    }
    public function contactUsStore(Request $request)
    {
        if (!empty($request->phone)) {
            $request->merge([
                'phone' => phone_number_format('255', $request->get('phone'))
            ]);
        }
        if ($request->has('first_name')) {
            $request->merge([
                'first_name' => ucwords(strtolower($request->get('first_name')))
            ]);
        }
        if ($request->has('last_name')) {
            $request->merge([
                'last_name' => ucwords(strtolower($request->get('last_name')))
            ]);
        }
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' =>  ['required', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'message' => 'required',
        ]);
        DB::beginTransaction();
        ContactUs::create($request->except('_token'));
        DB::commit();
        return redirect()->back()->with('success', 'Thank you for Contact Us ');
    }
    public function refundPolicy()
    {
        return view('web.refund-policy');
    }
    public function privacyPolicy()
    {
        return view('web.privacy-policy');
    }
    public function gallery()
    {
        $galleries =  Gallery::inRandomOrder()->limit(24)->get();
        return view('web.gallery.index', compact('galleries'));
    }
    public function subscribe(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);
            $email = $request->all()['email'];
            if ($validator->fails()) {
                $existemail = Subscriber::where(['email' => $email])->first();
                if (!empty($existemail)) {
                    $validator->errors()->add('email', 'The email already subscribe to our newsletter.');
                }
                return redirect()->back()->with('info', 'The email already subscribe to our newsletter.');
            }
            if (!$validator->fails()) {
                $existemail = Subscriber::where(['email' => $email])->first();
                if ($existemail !== null) {
                    return redirect()->back()->with('info', 'The email already subscribe to our newsletter.');
                }
            }
            Subscriber::create(
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
        } catch (ValidationException $e) {
            DB::rollBack();
            throw ($e);
            return back();
        } catch (Swift_TransportException $e) {
            DB::rollBack();
            return back()->with('error', 'There was technical problen. Please try again latter!.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back();
        }
        DB::commit();
        return redirect()->back()->with('success', 'Thank you for subscribing to our email, please check your inbox');
    }
    public function callback(Request $request)
    {
        $transactionref = $request->CompanyRef;
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;
        $request->merge([
            'transToken' =>  $transactiontoken,
        ]);
        $payments = PushPayment::where('transactionref', $transactionref)->first()
            ?? abort(404);

        $dpo = new Dpo();
        $verify = $dpo->verifyToken($request);
        if ($verify['Result'] === '000') {
            //Paid
            //send SMS to user after complete payment
            if ($verify['CustomerPhone'] != null) {
                $phonenumber = $verify['CustomerPhone'];
                $base_url = 'https://messaging-service.co.tz/api/sms/v1/text/single';
                $from = 'SHAMBADUNIA';
                $to = $phonenumber;
                $text = 'Habari ' . $verify['CustomerName'] . ' malipo yako ya TZS ' . $verify['TransactionAmount'] . ' yamepolewa. Risiti Namba ' . $verify['TransactionApproval'] . '. Kwa msaada zaidi piga simu :+255754222800.';
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
            }
            ////////////////////Marathon Update///////////////////////////////////////////////////
            DB::beginTransaction();
            $models = [MarathonRegistration::class, ExpoRegistration::class, AgriTourism::class];
            foreach ($models as $model) {
                $record = $model::where('transactionref', $transactionref)
                    ->where('paid', '=', '0')
                    ->first();
                if ($record) {
                    $record->paid = 1;
                    $record->save();
                    break;
                }
            }
            //////////////////Payment Update////////////////
            $payments->update([
                'result' => $verify['Result'],
                'resultexplanation' => $verify['ResultExplanation'],
                'customername' => $verify['CustomerName'],
                'customercredit' => $verify['CustomerCredit'],
                'customercredittype' => $verify['CustomerCreditType'],
                'transactionapproval' => $verify['TransactionApproval'],
                'transactioncurrency' => $verify['TransactionCurrency'],
                'transactionamount' => $verify['TransactionAmount'],
                'fraudalert' => $verify['FraudAlert'],
                'fraudexplnation' => $verify['FraudExplnation'],
                'transactionnetamount' => $verify['TransactionNetAmount'],
                'transactionsettlementdate' => $verify['TransactionSettlementDate'],
                'transactionrollingreserveamount' => $verify['TransactionRollingReserveAmount'],
                'transactionrollingreservedate' => $verify['TransactionRollingReserveDate'],
                'transactionfinalcurrency' => $verify['TransactionFinalCurrency'],
                'transactionfinalamount' => $verify['TransactionFinalAmount'],
                'customerphone' => $verify['CustomerPhone'],
                'customercountry' => $verify['CustomerCountry'],
                'customercity' => $verify['CustomerCity'],
                'customerzip' => $verify['CustomerZip'],
                'mobilepaymentrequest' => $verify['MobilePaymentRequest'],
                'accref' => $verify['AccRef'],
                'status' => 'Paid',
            ]);
        } else {
            $payments->update([
                'result' => $verify['Result'],
                'resultexplanation' => $verify['ResultExplanation'],
                'customername' => $verify['CustomerName'],
                'customercredit' => $verify['CustomerCredit'],
                'customercredittype' => $verify['CustomerCreditType'],
                'transactionapproval' => $verify['TransactionApproval'],
                'transactioncurrency' => $verify['TransactionCurrency'],
                'transactionamount' => $verify['TransactionAmount'],
                'fraudalert' => $verify['FraudAlert'],
                'fraudexplnation' => $verify['FraudExplnation'],
                'transactionnetamount' => $verify['TransactionNetAmount'],
                'transactionsettlementdate' => $verify['TransactionSettlementDate'],
                'transactionrollingreserveamount' => $verify['TransactionRollingReserveAmount'],
                'transactionrollingreservedate' => $verify['TransactionRollingReserveDate'],
                'transactionfinalcurrency' => $verify['TransactionFinalCurrency'],
                'transactionfinalamount' => $verify['TransactionFinalAmount'],
                'customerphone' => $verify['CustomerPhone'],
                'customercountry' => $verify['CustomerCountry'],
                'customercity' => $verify['CustomerCity'],
                'customerzip' => $verify['CustomerZip'],
                'mobilepaymentrequest' => $verify['MobilePaymentRequest'],
                'accref' => $verify['AccRef'],
                'status' => 'Not Paid',
            ]);
        }
        DB::commit();
        return redirect()->route('web.index')->with('success', 'Payment Complete');
    }
    public function canceled(Request $request)
    {
        $transactionref = $request->CompanyRef;
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;
        $check_transaction = PushPayment::where('transactionref', $transactionref)->first() ?? abort(404);
        if ($check_transaction != null) {
            $check_transaction->update([
                'transactionref'        => $transactionref,
                'transactionapproval'   => $transactionapproval,
                'transactiontoken'      => $transactiontoken,
                'status'             => 'Canceled',
            ]);
            // go back to orders or proposals or features
        }
        return redirect()->route('web.index')->with('error', 'Payment Canceled');
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
        }
        return redirect()->route('web.index')->with('error', 'Payment Declined');
    }
}
