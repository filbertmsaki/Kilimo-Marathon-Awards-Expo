<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpoRequest;
use App\Models\AwardCategory;
use App\Models\ExpoRegistration;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpoRequest $request)
    {
        DB::beginTransaction();
        $exist = ExpoRegistration::expoExist(
            $request->company_name,
            $request->company_phone,
            $request->contact_person_phone,
        );
        if($exist){
            return redirect()->back()->with('warning', 'You have already registered in kilimo expo, please wait to be verified!');
        }
        ExpoRegistration::create($request->except('_token'));
        DB::commit();
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
    public function registration(){
        return view('web.event.expo.registration');
    }

}
