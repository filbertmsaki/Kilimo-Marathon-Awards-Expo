<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\MarathonRegistration;
use App\Models\Payment\Dpo;
use App\Models\Payment\DpoGroup;
use App\Models\Payment\PushPayment;
use Illuminate\Http\Request;

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
        // TODO Get Payments Settings
        $row_payment_settings = DpoGroup::first();
        // dd($row_payment_settings);
        $dpo_company_token      = $row_payment_settings->dpo_company_token;
        $payments = PushPayment::where('slug', $slug)->first();
        $transToken = $payments->transactiontoken;
        $data = [];
        $data['companyToken'] = $dpo_company_token;
        $data['transToken'] = $transToken;
        $dpo = new Dpo();
        $verified = $dpo->verifyToken($data);
        $token = $verified['result'];

        $result = $token['Result'];
        $resultexplanation = $token['ResultExplanation'];
        $customername = $token['CustomerName'];
        $customercredit = $token['CustomerCredit'];
        $customercredittype = $token['CustomerCreditType'];
        $transactionapproval = $token['TransactionApproval'];
        $transactioncurrency = $token['TransactionCurrency'];
        $transactionamount = $token['TransactionAmount'];
        $fraudalert = $token['FraudAlert'];
        $fraudexplnation = $token['FraudExplnation'];
        $transactionnetamount = $token['TransactionNetAmount'];
        $transactionsettlementdate = $token['TransactionSettlementDate'];
        $transactionrollingreserveamount = $token['TransactionRollingReserveAmount'];
        $transactionrollingreservedate = $token['TransactionRollingReserveDate'];
        $transactionfinalcurrency = $token['TransactionFinalCurrency'];
        $transactionfinalamount = $token['TransactionFinalAmount'];
        $customerphone = $token['CustomerPhone'];
        $customercountry = $token['CustomerCountry'];
        $customercity = $token['CustomerCity'];
        $customerzip = $token['CustomerZip'];
        $mobilepaymentrequest = $token['MobilePaymentRequest'];
        $accref = $token['AccRef'];
        if ($result == 000) {
            //Paid
            $trimedmobile = substr($customerphone, -9);
            $phonenumber = '255' . $trimedmobile;
            MarathonRegistration::where('phone', $phonenumber)
                ->where('paid', '=', '0')
                ->update([
                    'paid' => 1
                ]);
            //////////////////Payment Update///////////////
            $payments->update([
                'result' => $result,
                'resultexplanation' => $resultexplanation,
                'customername' => $customername,
                'customercredit' => $customercredit,
                'customercredittype' => $customercredittype,
                'transactionapproval' => $transactionapproval,
                'transactioncurrency' => $transactioncurrency,
                'transactionamount' => $transactionamount,
                'fraudalert' => $fraudalert,
                'fraudexplnation' => $fraudexplnation,
                'transactionnetamount' => $transactionnetamount,
                'transactionsettlementdate' => $transactionsettlementdate,
                'transactionrollingreserveamount' => $transactionrollingreserveamount,
                'transactionrollingreservedate' => $transactionrollingreservedate,
                'transactionfinalcurrency' => $transactionfinalcurrency,
                'transactionfinalamount' => $transactionfinalamount,
                'customerphone' => $customerphone,
                'customercountry' => $customercountry,
                'customercity' => $customercity,
                'customerzip' => $customerzip,
                'mobilepaymentrequest' => $mobilepaymentrequest,
                'accref' => $accref,
                'status' => 'Paid',
            ]);
            return redirect()->back()->with('success', $payments->resultexplanation);
        } else {
            //OverPaid/underpaid

            $payments->update([
                'result' => $result,
                'resultexplanation' => $resultexplanation,
                'customername' => $customername,
                'customercredit' => $customercredit,
                'transactionapproval' => $transactionapproval,
                'transactioncurrency' => $transactioncurrency,
                'transactionamount' => $transactionamount,
                'fraudalert' => $fraudalert,
                'fraudexplnation' => $fraudexplnation,
                'transactionnetamount' => $transactionnetamount,
                'transactionsettlementdate' => $transactionsettlementdate,
                'transactionrollingreserveamount' => $transactionrollingreserveamount,
                'transactionrollingreservedate' => $transactionrollingreservedate,
                'transactionfinalcurrency' => $transactionfinalcurrency,
                'transactionfinalamount' => $transactionfinalamount,
                'customerphone' => $customerphone,
                'customercountry' => $customercountry,
                'customercity' => $customercity,
                'customerzip' => $customerzip,
                'mobilepaymentrequest' => $mobilepaymentrequest,
                'accref' => $accref,
                'customercredittype' => $customercredittype,
                'status' => 'Not Paid',
            ]);
            return redirect()->back()->with('warning', $payments->resultexplanation);
        }
    }
}
