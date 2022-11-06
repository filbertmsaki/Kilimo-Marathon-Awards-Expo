<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\AwardRequest;
use App\Models\AwardCategory;
use App\Models\AwardMarathonSetting;
use App\Models\AwardNominee;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $updates = AwardNominee::all();
        foreach ($updates as $update) {
            if ($update->company_individual == 'Individual') {

                $update->update([
                    'entry' => 1
                ]);
            } else {
                $update->update([
                    'entry' => 2
                ]);
            }
        }
        $categories = AwardCategory::all();
        $currrentYear = date('Y');
        $nominees = AwardNominee::with('awardcategory')
            ->whereYear('created_at', '=', $currrentYear)
            ->latest()
            ->get();

        return view('admin.events.award.index', compact('nominees', 'categories'));
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
    public function awardValidation($request)
    {
        if (!empty($request->company_phone)) {
            $request->merge([
                'company_phone' => phone_number_format($request->phonecode, $request->company_phone)
            ]);
            $request->validate([
                'company_phone' => ['required', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            ]);
        }
        if (!empty($request->contact_person_phone)) {
            $request->merge([
                'contact_person_phone' => phone_number_format($request->phonecode, $request->contact_person_phone)
            ]);
            $request->validate([
                'contact_person_phone' => ['required', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            ]);
        }
        if (!empty($request->company_email)) {
            $request->validate([
                'company_email' => 'required|min:3|max:255',
            ]);
        }
        if (!empty($request->contact_person_email)) {
            $request->validate([
                'contact_person_email' => 'required|min:3|max:255',
            ]);
        }
        if (!empty($request->company_name)) {
            $request->merge([
                'company_name' => ucwords(strtolower($request->get('company_name')))
            ]);
        }
        if (!empty($request->service_name)) {
            $request->merge([
                'service_name' => ucwords(strtolower($request->get('service_name')))
            ]);
        }
        if (!empty($request->contact_person_name)) {
            $request->merge([
                'contact_person_name' => ucwords(strtolower($request->get('contact_person_name')))
            ]);
        }
        if (!empty($request->address)) {
            $request->merge([
                'address' => ucwords(strtolower($request->get('address')))
            ]);
        }
        if (!empty($request->company_details)) {
            $request->merge([
                'company_details' => ucwords(strtolower($request->get('company_details')))
            ]);
        }
    }
    public function store(Request $request)
    {
        $this->awardValidation($request);
        $request->validate([
            'entry' => 'required|numeric',
            'phonecode' => 'required|numeric',
            'category_id' => 'required',
            'company_name' => 'required|string',
            'service_name' => 'required|string',
        ]);
        DB::beginTransaction();
        $exist = AwardNominee::nomineeExist(
            $request->company_name,
            $request->category_id,
            $request->company_phone,
            $request->contact_person_phone
        );
        if ($exist) {
            return redirect()->back()->with('warning', 'You have already registered in this category, please wait to be verified!');
        }
        if ($request->entry == 1) {
            $request->merge([
                'company_phone' => null,
                'company_email' => null,
            ]);
        }
        AwardNominee::create($request->except('_token'));
        DB::commit();
        return redirect()->back()->with('success', 'You have successful register to kilimo awards!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nominees = AwardNominee::with('awardcategory')
            ->whereYear('created_at', $id)
            ->where('verified', 1)
            ->orderBy('category_id', 'desc')->get();
        return view('admin.events.award.show', compact('nominees', 'id'));
    }
    public function awardsWinners($id)
    {

        $nominees = AwardNominee::with('awardcategory')
            ->whereYear('created_at', '2022')
            ->where('verified', 1)
            ->orderBy('category_id', 'desc')->get();


        return view('admin.events.award.winners', compact('nominees'));
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
        $this->awardValidation($request);
        $request->validate([
            'entry' => 'required|numeric',
            'phonecode' => 'required|numeric',
            'category_id' => 'required',
            'company_name' => 'required|string',
            'service_name' => 'required|string',
        ]);
        DB::beginTransaction();
        if ($request->entry == 1) {
            $request->merge([
                'company_phone' => null,
                'company_email' => null,
            ]);
        }
        $nominee = AwardNominee::where('slug', $request->nominee_id)->first() ?? abort(404);

        $nominee->update($request->except('_token', '_method'));

        DB::commit();
        return redirect()->back()->with('success', 'You have successful update your informations!');
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
    public function destroyAll(Request $request)
    {
        $id = $request->award_id;
        foreach ($id as $user) {
            $deleted = AwardNominee::where('id', $user)->delete();
        }
        return redirect()->back()->with('danger', 'Award Nominee  deleted successfully!');
    }
    public function settingIndex()
    {
        $settings = AwardMarathonSetting::get()->first();
        return view('admin.events.award.settings', compact('settings'));
    }
    public function settingStore(Request $request)
    {
        $this->validate($request, [
            'vote' => 'boolean',
            'vote_time_remain' => 'required',
            'awards_registration' => 'boolean',
            'awards_registration_time_remain' => 'required',
        ]);
        $vote_time_remain = Carbon::createFromFormat('Y-m-d\TH:i', $request->vote_time_remain);
        $awards_registration_time_remain = Carbon::createFromFormat('Y-m-d\TH:i', $request->awards_registration_time_remain);

        $settings = AwardMarathonSetting::updateOrCreate([
            'id' => $request->general_settings_id
        ], [
            'vote' => $request->vote,
            'vote_time_remain' => $vote_time_remain,
            'awards_registration' => $request->awards_registration,
            'awards_registration_time_remain' => $awards_registration_time_remain,
        ]);
        if ($settings) {
            return redirect()->back()->with('success', 'Award Settings Successfully  Updated!');
        } else {
            return redirect()->back()->with('danger', 'Award Settings Fail to Update!');
        }
    }
}
