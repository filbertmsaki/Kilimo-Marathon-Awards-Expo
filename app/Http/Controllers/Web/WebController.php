<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SubscribeMail;
use App\Models\AgriTourism;
use App\Models\ContactUs;
use App\Models\ExpoRegistration;
use App\Models\Gallery;
use App\Models\MarathonRegistration;
use App\Models\Partner;
use App\Models\Payment\Dpo;
use App\Models\Payment\PushPayment;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Swift_TransportException;

class WebController extends Controller
{
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
