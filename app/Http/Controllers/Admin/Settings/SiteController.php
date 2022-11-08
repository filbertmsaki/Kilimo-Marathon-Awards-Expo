<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_settings = GeneralSetting::get()->first();

        return view('admin.settings.site-settings', compact('site_settings'));
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
            'site_name' => 'required|min:3',
            'site_tagline' => 'required|min:3',
            'site_url' => 'required|min:3',
        ]);
        $id = $request->general_settings_id;
        DB::beginTransaction();
        $general_settings = GeneralSetting::updateOrCreate([
            'id' => $request->general_settings_id,
        ], $request->except('_token', 'general_settings_id', 'site_logo', 'site_icon'));

        if (!empty($request->site_icon)) {
            $request->validate([
                'site_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=1/1',
            ]);
            if ($site_icon = $request->file('site_icon')) {
                $destinationPath = 'upload/logo/';
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $site_icon_name = $destinationPath . 'site_icon_' . date('YmdHis') . "." . $site_icon->getClientOriginalExtension();
                $site_icon->move($destinationPath, $site_icon_name);
                $request->merge([
                    'site_icon' => $site_icon_name,
                ]);
                if($general_settings->site_icon){
                    if (file_exists(public_path($general_settings->site_icon))) {
                        unlink($general_settings->site_icon);
                    }
                }
               
            }
            $general_settings->update([
                'site_icon' => $site_icon_name,
            ]);
        }
        if (!empty($request->site_logo)) {
            $request->validate([
                'site_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($site_logo = $request->file('site_logo')) {
                $destinationPath = 'upload/logo/';
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $site_logo_name = $destinationPath . 'site_logo_' . date('YmdHis') . "." . $site_logo->getClientOriginalExtension();
                $site_logo->move($destinationPath, $site_logo_name);
                $request->merge([
                    'site_logo' => $site_logo_name,
                ]);
                if($general_settings->site_logo){
                    if (file_exists(public_path($general_settings->site_logo))) {
                        unlink($general_settings->site_logo);
                    }
                }
               
            }
            $general_settings->update([
                'site_logo' => $site_logo_name,
            ]);
        }
        DB::commit();
        return redirect()->back()->with('success', 'Site Settings Data Sucessfull Updated!');
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
