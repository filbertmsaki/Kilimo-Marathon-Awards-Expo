<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpoRequest;
use App\Models\AwardCategory;
use App\Models\ExpoRegistration;
use App\Models\Payment\Dpo;
use App\Models\Payment\PushPayment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\DB;

class ExpoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.event.expo.index');
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
    public function getStatus()
    {
        if (FacadesRequest::is('api*')) {
            if (!isExpoActive()) {
                return response()->json(['message' => trans('expo.notification.closed')], Response::HTTP_NOT_FOUND);
            }
            return response()->json(['message' => trans('expo.notification.opened')], Response::HTTP_FOUND);
        }
        abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpoRequest $request)
    {
        if (FacadesRequest::is('api*')) {
            if (!isExpoActive()) {
                return response()->json(['message' => trans('expo.notification.closed')], Response::HTTP_NOT_FOUND);
            }
            if ($request->entry == 'Mtu Binafsi' || $request->entry == 'Individual') {
                $request->merge([
                    'entry' => 1,
                    'company_phone' => null,
                    'company_email' => null,
                    'phonecode' => 255,

                ]);
            } else if ($request->entry == 'Kampuni' || $request->entry == 'Company') {
                $request->merge([
                    'entry' => 2
                ]);
            }
        }

        $exist = ExpoRegistration::expoExist(
            $request->company_name,
            $request->company_phone,
            $request->contact_person_phone,
        );
        if ($exist) {
            if (FacadesRequest::is('api*')) {
                return response()->json(['message' => trans('expo.notification.already-registered')], Response::HTTP_FOUND);
            }
            return redirect()->back()->with('warning', trans('expo.notification.already-registered'));
        }
        $request->merge([
            'city' => $request->address,
            'amount' => 500000,
            'description' => 'Payment for Agribusiness Exhibition Registration',
            'iso' => 'TZ',
            'zip' => 12345,
            'transactionref' => 'KMEXPO' . time(),
            'phonecode' => 255,
            'first_name' => $request->company_name,
            'last_name' => "",
            'phone' => $request->contact_person_phone,
            'email' => $request->contact_person_email,
        ]);
        DB::beginTransaction();
        $expo = ExpoRegistration::create($request->except('_token'));
        if ($expo) {
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
        if (FacadesRequest::is('api*')) {
            return response()->json(['message' => trans('expo.notification.registered')],  Response::HTTP_CREATED);
        }
        return redirect()->back()->with('success', trans('expo.notification.registered'));
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
    public function registration()
    {
        return view('web.event.expo.registration');
    }
}
