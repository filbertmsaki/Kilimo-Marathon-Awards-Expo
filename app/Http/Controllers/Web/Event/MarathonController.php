<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarathonRequest;
use App\Models\MarathonRegistration;
use App\Models\Payment\Dpo;
use App\Models\Payment\PushPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;

use function GuzzleHttp\Promise\all;

class MarathonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.event.marathon.index');
    }
    public function registration()
    {
        if (!isMarathonActive()) {
            abort(404);
        }
        return view('web.event.marathon.registration');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(401);
    }
    public function getStatus()
    {
        if (FacadesRequest::is('api*')) {
            if (!isMarathonActive()) {
                return response()->json('Marathon Registaration is cloded for now, please try again latter!.', 400);
            }
            return response()->json('Marathon Registaration is now open, you may now proceed to another steps!.', 201);
        }
        abort(401);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarathonRequest $request)
    {

        if (!isMarathonActive()) {
            abort(401);
        }
        $payment = $request->payment;
        DB::beginTransaction();
        MarathonRegistration::create($request->except('_token'));
        DB::commit();
        $request->merge([
            'city' => $request->address,
            'amount' => 35000,
            'description' => 'Payment for ' . $request->event . ' Km running',
            'iso' => 'TZ',
            'zip' => 12345,
            'token' => 'KME' . time(),

        ]);

        if ($payment == 'lipa_number') {
            return ' lipa_number';
        } else {
            $dpo = new Dpo();
            $tokens = $dpo->createToken($request);
            if ($tokens['success'] === true) {
                $request->merge([
                    'transToken' =>  $tokens['TransToken'],
                ]);
                if (FacadesRequest::is('api*')) {
                    if ($request->payment_option == 'Tigo') {
                        $payment_options = 'TIGOdebitMandate';
                    }
                    if ($request->payment_option == 'Vodacom') {
                        $payment_options = 'Selcom_webPay';
                    }
                    if ($request->payment_option == 'Airtel') {
                        $payment_options = 'Selcom_webPay_Airtel';
                    }
                    $request->merge([
                        'mno' =>   $payment_options,
                        'country' => 'Tanzania',
                    ]);

                    $mobilePay = $dpo->ChargeTokenMobile($request);
                    if (!empty($mobilePay) && $mobilePay != '') {
                        if ($mobilePay['success'] = true) {
                            $payment_details = $mobilePay['instructions'];
                            return response()->json($payment_details, 200);

                        }
                    }
                     return response()->json('Error occur, please try again latter!', 400);
                }
                $verify = $dpo->verifyToken($request);
                if ($verify['Result'] === '900') {
                    $payment_url = $dpo->getPaymentUrl($request);
                    // Save the transaction reference
                    // $payment = PushPayment::create([
                    //     'transactionref' => $request->token,
                    //     'customerphone' => $request->phone,
                    //     'transactionamount' => $request->amount,
                    //     'transactiontoken' =>  $request->transToken,
                    //     'status' => 'pending',
                    // ]);
                    return redirect()->to($payment_url);
                }
            }
        }
        return redirect()->back()->with('error', 'Error occur, please try again latter!');
    }


    public function mobilePayment($request)
    {
        $dpo = new Dpo();
        $tokens = $dpo->createToken($request);
        if ($tokens['success'] == true) {
            $mobilePay = $dpo->ChargeTokenMobile($request);
            if (!empty($mobilePay) && $mobilePay != '') {
                if ($mobilePay['success'] = true) {
                    $payment_details = $mobilePay['result'];
                    return   $payment_details;
                }
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(401);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(401);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(401);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(401);
    }
}
