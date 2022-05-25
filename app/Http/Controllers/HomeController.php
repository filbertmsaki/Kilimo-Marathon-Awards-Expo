<?php

namespace App\Http\Controllers;

use App\Models\Payment\Dpo;
use App\Models\Payment\DpoGroup;
use App\Models\Payment\Payment;
use App\Models\Payment\PushPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    const CALLBACK_URL = '/callback';
    const BACK_URL = '/canceled';
    const DECLINED_URL = '/declined';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function payment(){
                    $data = [];
                    $data['paymentAmount'] =  100;
                    $data['customerFirstName'] ='Filbert';
                    $data['customerLastName'] = 'Msaki';
                    $data['customerAddress'] = 'Ubungo, Dar Es Salaam';
                    $data['customerCity'] = 'Dar Es Slaam';
                    $data['customerPhone'] = '762650393';
                    $data['customerEmail'] =  'filymsaki@gmail.com';
                    $data['customerCountry'] = 'TZ';
                    $data['customerZip'] = '0000';
                    $data['companyRef'] = 'KME'.''.time(); //$params['invoiceid']; (On this line you can put uniq id of your service)
                    $data['orderDescription'] =  'Test Description';

                    
                    $dpo = new Dpo();
                    
                    $tokens = $dpo->createToken($data); 
                   
                    if ($tokens['success'] === 'true') {
                
                        $data['transToken'] = $tokens['transToken'];
                        $verify = $dpo->verifyToken($data);
                        
                        if (!empty($verify) && $verify != '') {
                            $verify = new \SimpleXMLElement($verify);
                            if ($verify->Result->__toString() === '900') {
                                
                                $payment_url = $dpo->getPaymentUrl($tokens);

                                //Save the transaction reference
                                $slug = Str::random(40);
                                $i = 0;
                                $i = 0;
                                while(PushPayment::where('slug',$slug)->exists())
                                {
                                    $i++;
                                    $slug = Str::random(40).$i;
                                }
                                    $payment = PushPayment::create([
                                        'slug' => $slug ,
                                        'transactionref' => $data['companyRef'],
                                        'customerphone' => $data['customerPhone'], 
                                        'transactionamount' => $data['paymentAmount'],
                                        'status' => 'pending',
                                ]);
                                return Redirect::to($payment_url);
                            }
                        }
                    }
                    
    }
    public function callback(Request $request){
        $transactionref = $request->CompanyRef; 
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;
        $check_transaction = PushPayment::where('transactionref',$transactionref)->first();

        if ($check_transaction != null) {
            $check_transaction ->update([
                'transactionref'        =>$transactionref,
                'transactionapproval'   =>$transactionapproval,
                'transactiontoken'      =>$transactiontoken ,
                'status'                =>'Paid',
                'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
            ]);
    
            // go back to orders or proposals or features
    
        } else {
            // insert new record and mark it flagged
            $slug = Str::random(40);
            $i = 0;
            $i = 0;
            while(PushPayment::where('slug',$slug)->exists())
            {
                $i++;
                $slug = Str::random(40).$i;
            }
            $payment = PushPayment::create([
                'slug'                  =>$slug,
                'transactionref'        =>$transactionref,
                'transactionapproval'   =>$transactionapproval,
                'transactiontoken'      =>$transactiontoken ,
                'status'                =>'Flagged',
        ]);
    
            // go back to orders or proposals or features
        }

         return redirect()->route('index')->with('message','Payment Done');
    }
    public function canceled(Request $request){
        $transactionref = $request->CompanyRef; 
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;

        $check_transaction = PushPayment::where('transactionref',$transactionref)->first();
       

        if ($check_transaction != null) {
            $check_transaction ->update([
                'transactionref'        =>$transactionref,
                'transactionapproval'   =>$transactionapproval,
                'transactiontoken'      =>$transactiontoken ,
                'status'             =>'Canceled',
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);
    
            // go back to orders or proposals or features
    
        } else {
            // insert new record and mark it flagged
            
                    $slug = Str::random(40);
                    $i = 0;
                    $i = 0;
                    while(PushPayment::where('slug',$slug)->exists())
                    {
                        $i++;
                        $slug = Str::random(40).$i;
                    }
                    $payment = PushPayment::create([
                        'slug'                  =>$slug,
                        'transactionref'        =>$transactionref,
                        'transactionapproval'   =>$transactionapproval,
                        'transactiontoken'      =>$transactiontoken ,
                        'status'                =>'Flagged',
                ]);
    
        
    
            // go back to orders or proposals or features
        }

         return redirect()->route('index')->with('canceled','Payment Canceled');

    }
    public function declined(Request $request){
        $transactionref = $request->CompanyRef; 
        $transactiontoken = $request->TransactionToken;
        $transactionapproval = $request->CCDapproval;

        $check_transaction = PushPayment::where('transactionref',$transactionref)->first();
       

        if ($check_transaction != null) {
            $check_transaction ->update([
                'transactionref'        =>$transactionref,
                'transactionapproval'   =>$transactionapproval,
                'transactiontoken'      =>$transactiontoken ,
                'status'             =>'Declined',
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);
    
            // go back to orders or proposals or features
    
        } else {
            // insert new record and mark it flagged
            

                $slug = Str::random(40);
                $i = 0;
                $i = 0;
                while(PushPayment::where('slug',$slug)->exists())
                {
                    $i++;
                    $slug = Str::random(40).$i;
                }
                $payment = Payment::create([
                    'slug'                  =>$slug,
                    'transactionref'        =>$transactionref,
                    'transactionapproval'   =>$transactionapproval,
                    'transactiontoken'      =>$transactiontoken ,
                    'status'                =>'Flagged',
            ]);
    
        
    
            // go back to orders or proposals or features
        }

         return redirect()->route('index')->with('declined','Payment Declined');
        

    }
}
