<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpoRequest;
use App\Models\AwardCategory;
use App\Models\ExpoRegistration;
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
        DB::beginTransaction();
        ExpoRegistration::create($request->except('_token'));
        DB::commit();
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
