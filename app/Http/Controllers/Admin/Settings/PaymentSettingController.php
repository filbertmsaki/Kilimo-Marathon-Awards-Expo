<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Payment\DpoGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dpo_settings = DpoGroup::get()->first();
        return view('admin.settings.dpo-group-settings',compact('dpo_settings'));
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
        $request->validate([
            'enable_dpo' => 'required',
            'dpo_sandbox' => 'required',
            'dpo_base_url' => 'required',
            'dpo_default_currency' => 'required',
            'dpo_default_country' => 'required',
            'dpo_default_service' => 'required',
            'dpo_default_service_description' => 'required',
            'dpo_company_token' => 'required|min:35|max:36',
        ]);
        DB::beginTransaction();
        $general_settings = DpoGroup::updateOrCreate([
            'slug' => $request->general_settings_id,
        ], $request->except('_token', 'general_settings_id'));
        DB::commit();

        return redirect()->back()->with('success', 'Dpo Group Services Successfully Updated ');
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
