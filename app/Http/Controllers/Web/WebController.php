<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SubscribeMail;
use App\Models\ContactUs;
use App\Models\Gallery;
use App\Models\Subscriber;
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
        return view('web.index');
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
                'phone' => phone_number_format($request->get('phonecode'), $request->get('phone'))
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
    public function gallery()
    {
        $galleries =  Gallery::inRandomOrder()->limit(24)->get();
        return view('web.gallery.index',compact('galleries'));
    }
    public function subscribe(Request $request)
    {

        DB::beginTransaction();
        try{
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
        }catch(ValidationException $e){
            DB::rollBack();
            throw($e);
            return back();
        }catch(Swift_TransportException $e){
            DB::rollBack();
            return back()->with('error','There was technical problen. Please try again latter!.');
        }catch(\Exception $e){
            DB::rollBack();
            return back();
        }
        DB::commit();
        return redirect()->back()->with('success', 'Thank you for subscribing to our email, please check your inbox');
    }
}
