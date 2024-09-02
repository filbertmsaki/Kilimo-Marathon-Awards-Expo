<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Models\AgriTourism;
use App\Models\Payment\Dpo;
use App\Models\Payment\FlutterwaveModel;
use App\Models\Payment\PushPayment;
use App\Services\FlutterwaveService;
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
        // $request->merge([
        //     'city' => $request->address,
        //     'amount' => 100000,
        //     'description' => 'Payment for Agri Tourism Registration',
        //     'iso' => 'TZ',
        //     'zip' => 12345,
        //     'transactionref' => 'KMAGRITOUR' . time(),
        //     'phonecode' => 255,
        //     'first_name' => $request->full_name,
        //     'last_name' => "",
        // ]);
        $exist = AgriTourism::userExist();
        if ($exist) {
            if (FacadesRequest::is('api*')) {
                return response()->json(['message' => 'You have already registered in agri tourism.'], Response::HTTP_FOUND);
            }
            return redirect()->back()->with('warning', 'You have already registered in agri tourism.');
        }
        DB::beginTransaction();
        try {
            $agriTourism = AgriTourism::create($validatedData);
            $data = [
                'reference' => $agriTourism->reference,
                'amount' => '100000',
                'currency' => 'TZS',
                'customer_email' => $agriTourism->email ?? "info@kilimomarathon.co.tz",
                'customer_name' => $agriTourism->full_name,
                'customer_phonenumber' => $agriTourism->phone,
                'title' => 'Payment for Agri Tourism Registration',
            ];
            $response = FlutterwaveService::createPayment($data);
            $statusCode = $response->getStatusCode();
            $results = $response->getData();
            if ($statusCode === Response::HTTP_CREATED) {
                $flutterwave = FlutterwaveModel::create([
                    'payable_id' => $agriTourism->id,
                    'payable_type' => AgriTourism::class,
                    'reference' => $agriTourism->reference,
                    'amount' => $data['amount'],
                    'currency' => $data['currency'],
                    'customer_phone_number' => $data['customer_phonenumber'],
                    'customer_name' => $data['customer_name'],
                    'customer_email' => $data['customer_email'],
                ]);

                DB::commit();
                if ($request->is('api*') || $request->ajax()) {
                    return response()->json(['payment_url' => $results], Response::HTTP_OK);
                }
                return redirect()->away($results);
            } else {
                DB::rollBack();
                $message = $results->message;
                if ($request->is('api*') || $request->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $message
                    ], 400);
                }
                return redirect()->back()->with('error', $message);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->is('api*') || $request->ajax()) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
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
