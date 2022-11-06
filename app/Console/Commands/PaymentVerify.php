<?php

namespace App\Console\Commands;

use App\Models\MarathonRegistration;
use App\Models\Payment\Dpo;
use Illuminate\Console\Command;
use App\Models\Payment\DpoGroup;
use App\Models\Payment\PushPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PaymentVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify new payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    {
        $pushpayments = PushPayment::where('status', '!=', 'Paid')->get();
        foreach ($pushpayments as $pay) {
            $transToken = $pay->transactiontoken;
            $request->merge([
                'transToken' =>  $transToken,
            ]);
            $payments = PushPayment::where('slug', $pay->slug)->first()
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
                    $text = 'Habari ' . $verify['CustomerName'] . ' malipo yako ya TZS ' . $verify['TransactionAmount'] . ' kwa ajili ya kushiriki kwenye KILIMO MARATHON yamekamilika.Risiti Namba ' . $verify['TransactionApproval'] . '. Kwa msaada zaidi piga simu :+255754222800.';
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
        }
    }
}
