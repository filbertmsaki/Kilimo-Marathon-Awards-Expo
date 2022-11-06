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
                return response()->json('Expo Registaration is cloded for now, please try again latter!.', Response::HTTP_NOT_FOUND);
            }
            return response()->json('Expo Registaration is now open, you may now proceed to another steps!.', Response::HTTP_FOUND);
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
                return response()->json('Expo Registaration is cloded for now, please try again latter!.', Response::HTTP_NOT_FOUND);
            }
        }
        $exist = ExpoRegistration::expoExist(
            $request->company_name,
            $request->company_phone,
            $request->contact_person_phone,
        );
        if ($exist) {
            if (FacadesRequest::is('api*')) {
                return response()->json('You have already registered in kilimo expo, please wait to be verified', Response::HTTP_FOUND);
            }
            return redirect()->back()->with('warning', 'You have already registered in kilimo expo, please wait to be verified!');
        }
        DB::beginTransaction();
        ExpoRegistration::create($request->except('_token'));
        DB::commit();
        if (FacadesRequest::is('api*')) {
            return response()->json('You have successful register to kilimo expo.',  Response::HTTP_CREATED);
        }
        return redirect()->back()->with('success', 'You have successful register to kilimo expo!');
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
