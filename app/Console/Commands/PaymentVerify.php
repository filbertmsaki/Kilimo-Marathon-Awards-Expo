<?php

namespace App\Console\Commands;

use App\Models\MarathonRegistration;
use App\Models\Payment\Dpo;
use Illuminate\Console\Command;
use App\Models\Payment\DpoGroup;
use App\Models\Payment\PushPayment;

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
    public function handle()
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
                ////////////////////Marathon Update///////////////////////////////////////////////////

                $marathon = MarathonRegistration::where('phone', $phonenumber)
                ->where('paid', '=', '0')
                ->update([
                    'paid' => 1
                ]);
                //////////////////Payment Update////////////////
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
}
