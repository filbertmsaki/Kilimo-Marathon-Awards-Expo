<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\MarathonRegistration;
use App\Models\Payment\Dpo;
use App\Models\Payment\DpoGroup;
use App\Models\Payment\PushPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DpoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currrentYear = date('Y');
        $payments = PushPayment::whereYear('created_at', '=', $currrentYear)
            ->orderByRaw("status = 'Paid' DESC",)
            ->latest()
            ->get();
        return view('admin.payment.dpo-index', compact('payments'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function verify(Request $request)
    {
        $slug = $request->pay_slug;
        $payments = PushPayment::where('slug', $slug)->first()
            ?? abort(404);
        $transactiontoken = $payments->transactiontoken;
        $request->merge([
            'transToken' =>  $transactiontoken,
        ]);
        $dpo = new Dpo();
        $verify = $dpo->verifyToken($request);
        if ($verify['Result'] === '000') {
            //Paid
            ////////////////////Marathon Update///////////////////////////////////////////////////
            DB::beginTransaction();
            $marathon = MarathonRegistration::where('transactionref', $payments->transactionref)
                ->where('paid', '=', '0')
                ->update([
                    'paid' => 1
                ]);
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
        return redirect()->back()->with('success', $payments->resultexplanation);
    }
}
