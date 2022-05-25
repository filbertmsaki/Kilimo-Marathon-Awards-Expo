<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Validator;



use App\Models\User;
use Exception;

class LoginController extends Controller
{
    public $successStatus = 200;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function loginpage(){
        return view('auth.loginwithotp');

    }
    
    public function sendOtp(Request $request){
        $this->validate($request,[
            'mobile' => ['required','max:12','min:12','regex:/^([0-9\s\-\+\(\)]*)$/' ],
            ]);
        $otp = rand(1000,9999);
        Log::info("otp = ".$otp);
      
        try {
            // send otp to mobile no using sms api
            // $basic  = new \Nexmo\Client\Credentials\Basic(getenv("NEXMO_KEY"), getenv("NEXMO_SECRET"));
            // $client = new \Nexmo\Client($basic);
            // $receiverNumber = $request->mobile;
            // $message = 'Your OTP code is '.$otp.' use this code to sigin in your FEM Creative Agency accout ';
            // $message = $client->message()->send([
            //     'to' => $receiverNumber,
            //     'from' => 'FEM Creative Agency',
            //     'text' => $message
            // ]);
            $user = User::where('mobile','=',$request->mobile)->update(['otp' => $otp]);
            return response()->json([$user],200);

              

        } catch (Exception $e) {

            dd("Error: ". $e->getMessage());

        }
    }

    public function loginWithOtp(Request $request){
        $this->validate($request,[
            'mobile' => ['required','max:12','min:12','regex:/^([0-9\s\-\+\(\)]*)$/'],
            'otp' => ['required','max:4','min:4','regex:/^([0-9\s\-\+\(\)]*)$/'],
            ]);
        
        Log::info($request);
        $user  = User::where([['mobile','=',request('mobile')],['otp','=',request('otp')]])->first();
        if( $user){
            Auth::login($user, true);
            User::where('mobile','=',$request->mobile)->update(['otp' => null]);
           
            return redirect()->route('admin.index');
        }
        else{
            return Redirect::back ();
        }
    }
}
