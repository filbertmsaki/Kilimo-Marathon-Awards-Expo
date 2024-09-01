<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarathonRequest;
use App\Models\MarathonRegistration;
use App\Models\Payment\Dpo;
use App\Models\Payment\FlutterwaveModel;
use App\Models\Payment\PushPayment;
use App\Services\FlutterwaveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use function GuzzleHttp\Promise\all;
use Symfony\Component\HttpFoundation\Response;


class MarathonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.event.marathon.index');
    }
    public function registration()
    {
        // if (!isMarathonActive()) {
        //     abort(404);
        // }
        return view('web.event.marathon.registration');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(401);
    }
    public function getStatus()
    {
        if (FacadesRequest::is('api*')) {
            if (!isMarathonActive()) {
                return response()->json(['message' => trans('marathon.notification.closed')],  Response::HTTP_NOT_FOUND);
            }
            return response()->json(['message' => trans('marathon.notification.opened')],  Response::HTTP_FOUND);
        }
        abort(401);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'age' => 'required|numeric|min:1|max:120',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'email' => ['required', 'string', 'email', 'max:255'],
            'event' => 'required|in:5,10,21,cycling',
            't_shirt_size' => 'required|in:S,M,L,XL,XXL',
            'address' => 'required|string|max:255',
            'payment' => 'required|in:online,cash',
        ]);

        if (!isMarathonActive()) {
            if ($request->is('api*') || $request->ajax()) {
                return response()->json(['message' => trans('marathon.notification.closed')], Response::HTTP_NOT_FOUND);
            }
            abort(401);
        }

        $exist = MarathonRegistration::runnerExist($request->email, $request->phone);
        if ($exist) {
            if ($request->is('api*') || $request->ajax()) {
                return response()->json(['message' => trans('marathon.notification.already-registered')], Response::HTTP_FOUND);
            }
            return redirect()->back()->with('warning', trans('marathon.notification.already-registered'));
        }

        DB::beginTransaction();
        try {
            $marathonRegistration = MarathonRegistration::create($request->except('_token'));
            // Create a description based on the event selected
            $eventDescription = '';
            switch ($request->event) {
                case '5':
                    $eventDescription = '5 Km Running';
                    break;
                case '10':
                    $eventDescription = '10 Km Running';
                    break;
                case '21':
                    $eventDescription = '21 Km Running';
                    break;
                case 'cycling':
                    $eventDescription = 'Cycling 100 Km';
                    break;
                default:
                    $eventDescription = 'Event';
                    break;
            }

            $data = [
                'reference' => $marathonRegistration->reference,
                'amount' => '35000',
                'currency' => 'TZS',
                'redirect_url' => 'https://20a2-197-250-51-156.ngrok-free.app/flw-redirect',
                'customer_email' => $marathonRegistration->email ?? "info@kilimomarathon.co.tz",
                'customer_name' => $marathonRegistration->name,
                'customer_phonenumber' => $marathonRegistration->phone,
                'title' => 'Payment for ' . $eventDescription,
            ];
            $response = FlutterwaveService::createPayment($data);
            $statusCode = $response->getStatusCode();
            $results = $response->getData();
            if ($statusCode === Response::HTTP_CREATED) {
                $flutterwave = FlutterwaveModel::create([
                    'payable_id' => $marathonRegistration->id,
                    'payable_type' => MarathonRegistration::class,
                    'reference' => $marathonRegistration->reference,
                    'amount' => $data['amount'],
                    'currency' => $data['currency'],
                    'customer_phone' => $data['customer_phonenumber'],
                    'customer_full_name' => $data['customer_name'],
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

    public function mobilePayment($request)
    {
        $dpo = new Dpo();
        $tokens = $dpo->createToken($request);
        if ($tokens['success'] == true) {
            $mobilePay = $dpo->ChargeTokenMobile($request);
            if (!empty($mobilePay) && $mobilePay != '') {
                if ($mobilePay['success'] = true) {
                    $payment_details = $mobilePay['result'];
                    return   $payment_details;
                }
            }
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
        abort(401);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(401);
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
        abort(401);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(401);
    }
}
