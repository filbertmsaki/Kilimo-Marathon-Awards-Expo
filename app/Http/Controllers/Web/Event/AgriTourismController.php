<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Models\AgriTourism;
use App\Models\Payment\Dpo;
use App\Models\Payment\PushPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;


class AgriTourismController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.event.agri-tourism.index');
    }
    public function registration()
    {
        return view('web.event.agri-tourism.registration');
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
        $validatedData =  $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'age' => 'nullable|integer',
            'gender' => 'required|string|max:1',
            'address' => 'nullable|string|max:255',
            'activities' => 'required|array',
            'emergency_contact' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:255',
            'additional_info' => 'nullable|string',
            'agree_checkbox' => 'accepted',
        ]);
        $request->merge([
            'city' => $request->address,
            'amount' => 100000,
            'description' => 'Payment for Agri Tourism Registration',
            'iso' => 'TZ',
            'zip' => 12345,
            'transactionref' => 'KMAGRITOUR' . time(),
            'phonecode' => 255,
            'first_name' => $request->full_name,
            'last_name' => "",
        ]);
        $exist = AgriTourism::userExist();
        if ($exist) {
            if (FacadesRequest::is('api*')) {
                return response()->json(['message' => 'You have already registered in agri tourism.'], Response::HTTP_FOUND);
            }
            return redirect()->back()->with('warning', 'You have already registered in agri tourism.');
        }
        DB::beginTransaction();
        $agri = AgriTourism::create($validatedData);
        if ($agri) {
            $dpo = new Dpo();
            $tokens = $dpo->createToken($request);
            if ($tokens['success'] === true) {
                $request->merge([
                    'transToken' =>  $tokens['TransToken'],
                ]);
                $verify = $dpo->verifyToken($request);
                if ($verify['Result'] === '900') {
                    $payment_url = $dpo->getPaymentUrl($request);
                    // Save the transaction reference
                    $payment = PushPayment::create([
                        'transactionref' => $request->token,
                        'customerphone' => $request->phone,
                        'transactionamount' => $request->amount,
                        'transactiontoken' =>  $request->transToken,
                        'status' => 'pending',
                    ]);
                    DB::commit();
                    return redirect()->to($payment_url);
                }
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', trans('strings.error'));
            }
        }
        DB::rollBack();
        return redirect()->back()->with('error', 'Unknown error occur.');
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
}
