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
        foreach($updates as $update){
            if($update->company_individual == 'Individual'){

                $update->update([
                    'entry'=>1
                ]);
            }else {
                $update->update([
                    'entry'=>2
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
    public function store(Request $request)
    {
        if (!empty($request->mobile)) {
            $request->merge([
                'mobile' => phone_number_format($request->get('phonecode'), $request->get('mobile'))
            ]);
            $request->validate([
                'mobile' => ['required', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            ]);
        }
        if (!empty($request->email)) {
            $request->validate([
                'email' => 'required|min:3|max:255',
            ]);
        }
        $request->validate([
            'full_name' => 'required|min:3|max:255',
            'phonecode' => 'required',
            'category_id' => 'required',
            'company_individual' => 'required',
            'verified' => 'required',
        ]);
        $full_name = $request->full_name;
        $email = $request->email;
        $phonecode = $request->phonecode;
        $mobile = $request->mobile;
        $address = $request->address;
        $category_id = $request->category_id;
        $company_individual = $request->company_individual;
        $verified = $request->verified;
        //check if phonenumber is empty
        if (empty($mobile)) {
            $faker = Factory::create();
            $mobile = $faker->numerify('255#########');
        }
        //Check if email is emapty
        if (empty($email)) {
            $faker = Factory::create();
            $email = $faker->unique()->email;
        }
        $currrentYear = date('Y');
        $nominee_exist = AwardNominee::where('email', $email)
            ->where('category_id', $category_id)
            ->where('mobile', $mobile)
            ->whereYear('created_at', '=', $currrentYear)
            ->exists();
        if ($nominee_exist) {
            return redirect()->back()->with('warning', 'You have already registered in this category');
        }
        AwardNominee::create(
            [
                'full_name' => $full_name,
                'phonecode' => $phonecode,
                'mobile' => $mobile,
                'email' => $email,
                'address' =>  $address,
                'category_id' => $category_id,
                'company_individual' => $company_individual,
                'verified' => $verified,
            ]
        );
        return redirect()->back()->with('success', 'Registration Sucessfull !');
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
            ->whereYear('created_at',$id)
            ->where('verified', 1)
            ->orderBy('category_id', 'desc')->get();
            return view('admin.events.award.show',compact('nominees','id'));
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
        if (!empty($request->mobile)) {
            $request->merge([
                'mobile' => phone_number_format($request->get('phonecode'), $request->get('mobile'))
            ]);
            $request->validate([
                'mobile' => 'required|min:10',
            ]);
        }
        if (!empty($request->email)) {
            $request->validate([
                'email' => 'required|min:3|max:255',
            ]);
        }
        $request->validate([
            'full_name' => 'required|min:3|max:255',
            'phonecode' => 'required',
            'category_id' => 'required',
            'company_individual' => 'required',
            'verified' => 'required|boolean|max:1',
        ]);
        $full_name = $request->full_name;
        $email = $request->email;
        $phonecode = $request->phonecode;
        $mobile = $request->mobile;
        $address = $request->address;
        $category_id = $request->category_id;
        $company_individual = $request->company_individual;
        $verified = $request->verified;
        //check if phonenumber is empty
        if (empty($mobile)) {
            $faker = Factory::create();
            $mobile = $faker->numerify('255#########');
        }
        //Check if email is emapty
        if (empty($email)) {
            $faker = Factory::create();
            $email = $faker->unique()->email;
        }
        $nominee = AwardNominee::where('slug', $request->nominee_id)->first() ?? abort(404);
        $nominee->update([
            'full_name' => $full_name,
            'phonecode' => $phonecode,
            'mobile' => $mobile,
            'email' => $email,
            'address' =>  $address,
            'category_id' => $category_id,
            'company_individual' => $company_individual,
            'verified' => $verified,
        ]);

        return redirect()->back()->with('success', 'Sucessfull Updated!');
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
