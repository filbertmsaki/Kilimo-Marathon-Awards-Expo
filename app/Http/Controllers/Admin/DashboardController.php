<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\ContactUs;
use App\Models\Subscriber;
use App\Models\Payment\Dpo;
use Illuminate\Support\Str;
use App\Models\AwardNominee;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Models\GeneralSetting;
use App\Models\Payment\DpoGroup;
use Illuminate\Support\Facades\DB;
use App\Models\Payment\PushPayment;
use App\Http\Controllers\Controller;
use App\Models\AwardMarathonSetting;
use App\Models\MarathonRegistration;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {

        $currrentYear = date('Y');
        $award_nominees = AwardNominee::where('Verified', '=', '1')
            ->whereYear('created_at', '=', $currrentYear)
            ->orderBy('id', 'asc')
            ->get();

        $award_category = AwardCategory::all();
        $marathon_runners = MarathonRegistration::whereYear('created_at', '=', $currrentYear)
            ->orderBy('id', 'asc')
            ->get();
        $subscribers = Subscriber::all();
        return view('admin.index')->with(['award_category' => $award_category, 'award_nominees' => $award_nominees, 'marathon_runners' => $marathon_runners, 'subscribers' => $subscribers]);
    }
    public function subscribers()
    {
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscribers')->with(['subscribers' => $subscribers]);
    }
    public function subscribers_delete($id)
    {
        $subscriber = Subscriber::where('id', $id)->delete();
        return redirect()->back()->with('danger', 'Subscriber deleted successfully!');
    }
    public function subscribers_delete_all(Request $request)
    {
        $id = $request->subscriber_id;
        foreach ($id as $user) {
            $deleted = Subscriber::where('id', $user)->delete();
        }
        return redirect()->back()->with('danger', 'Subscriber deleted successfully!');
    }
    public function contact_us()
    {
        $contact_us = ContactUs::latest()->get();
        return view('admin.contact-us')->with(['contact_us' => $contact_us]);
    }
    public function contact_us_view($id)
    {
        $where = array('id' => $id);
        $contact_us  = ContactUs::where($where)->first();
        return response()->json($contact_us, 200);
    }
    public function contact_us_update(Request $request)
    {
        $contact = ContactUs::where('id', $request->contact_id)->first();
        $contact->update([
            'seen_at' => new Carbon()
        ]);
        return redirect()->back()->with('success', 'Contact Marked to Seen!');
    }
    public function contact_us_delete($id)
    {
        $contact = ContactUs::where('id', $id)->delete();
        return redirect()->back()->with('danger', 'Contact deleted successfully!');
    }
    public function contact_us_delete_all(Request $request)
    {
        $id = $request->contact_id;
        foreach ($id as $user) {
            $deleted = ContactUs::where('id', $user)->delete();
        }
        return redirect()->back()->with('danger', 'Contact deleted successfully!');
    }
    public function gallery()
    {
        $gallery = Gallery::all();
        return view('admin.gallery.index')->with(['gallery' => $gallery]);
    }
    public function gallery_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required'],
            'alt_text' => ['required', 'string'],
            'event' => ['required', 'string'],
        ]);
        $event = $request->event;
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($gallery_image = $request->file('image')) {
            $destinationPath = 'gallery/' . date('Y') . '/' . date('m') . '/';
            $gallery_image_name = strtolower($event) . date('YmdHis') . "." . $gallery_image->getClientOriginalExtension();
            $gallery_image->move($destinationPath, $gallery_image_name);
        }
        $slug = Str::random(40);
        $i = 0;
        while (Gallery::where('slug', $slug)->exists()) {
            $i++;
            $slug = Str::random(39) . $i;
        }

        Gallery::create([
            'slug' => $slug,
            'image' => $gallery_image_name,
            'alt_text' => $request->alt_text,
            'event' => $event,
            'path' => $destinationPath,

        ]);
        return redirect()->back()->with('success', 'Carousel Created!');
    }
    public function gallery_edit($id)
    {
        $where = array('id' => $id);
        $gallery  = Gallery::where($where)->first();
        return response()->json($gallery, 200);
    }
    public function gallery_delete($id)
    {
        $gallery = Gallery::find($id);
        unlink($gallery->path . $gallery->image);
        Gallery::where('id', $gallery->id)->delete();
        return redirect()->back()->with('danger', 'Gallery Deleted Sucessfull!');
    }
    public function gallery_delete_all(Request $request)
    {
        $id = $request->gallery_id;
        foreach ($id as $id) {
            $gallery = Gallery::find($id);
            unlink($gallery->path . $gallery->image);

            $deleted = Gallery::where('id', $gallery->id)->delete();
        }
        return redirect()->back()->with('danger', 'Image Deleted Sucessfull!');
    }
    public function marathon_runners()
    {
        $currrentYear = date('Y');
        $marathon_runners = MarathonRegistration::whereYear('created_at', '=', $currrentYear)
            ->latest()
            ->get();
        return view('admin.marathon.marathon-runner')->with(['marathon_runners' => $marathon_runners]);
    }
    public function marathon_runners_edit($id)
    {
        $where = array('id' => $id);
        $marathon_runners  = MarathonRegistration::where($where)->first();
        return response()->json($marathon_runners, 200);
    }
    public function marathon_runners_add(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'region' => 'required',
            'phone' =>  ['required', 'max:13', 'unique:marathon_registrations'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:marathon_registrations'],
            'event' => 'required',
        ]);

        $full_name            = $request->full_name;
        $region                  = $request->region;

        $email                 = $request->email;
        $amount                = $request->amount;
        $description           = $request->description;
        $event               = $request->event;

        $trimedmobile = substr($request->phone, -9);
        $phonenumber = '255' . $trimedmobile;
        $general_slug = Str::random(40);

        $i = 0;
        while (MarathonRegistration::where('slug', $general_slug)->exists()) {
            $i++;
            $general_slug = Hash::make(Str::random(40) . $i);
        }
        $marathon_registration = MarathonRegistration::create(
            [
                'slug' => $general_slug,
                'full_name' => $full_name,
                'region' => $region,
                'phone' => $phonenumber,
                'email' => $email,
                'event' => $event,
                'paid' => 1,
            ]
        );
        return redirect()->back()->with('success', 'Marathon runner successfully Added!');
    }
    public function marathon_runners_store(Request $request)
    {

        $request->validate([
            'full_name' => 'required',
            'region' => 'required',
            'event' => 'required',
        ]);
        $full_name            = $request->full_name;
        $address               = $request->address;
        $region                  = $request->region;
        $event               = $request->event;

        $marathon_runner = MarathonRegistration::where('id', $request->marathon_runner_id)->first();
        if (!($request->email == $marathon_runner->email)) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:marathon_registrations'],
            ]);
            $marathon_runner->update([
                'email' => $request->email,
            ]);
        }
        if (!($request->phone == $marathon_runner->phone)) {
            $request->validate([
                'phone' =>  ['required', 'max:13', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'unique:marathon_registrations'],
            ]);
            $trimedmobile = substr($request->phone, -9);
            $phonenumber = '255' . $trimedmobile;
            $marathon_runner->update([
                'phone' => $phonenumber,
            ]);
        }

        $marathon_runner->update([
            'full_name' => $full_name,
            'address' => $address,
            'region' => $region,
            'event' => $event,
        ]);


        return redirect()->back()->with('success', 'Marathon runner successfully Update!');
    }
    public function marathon_runners_delete($id)
    {
        $marathon_runners_destroy = MarathonRegistration::where('id', $id)->delete();
        return redirect()->back()->with('danger', 'Marathon runner successfully Deleted!');
    }
    public function marathon_runners_delete_all(Request $request)
    {
        $id = $request->runner_id;
        foreach ($id as $user) {
            $deleted = MarathonRegistration::where('id', $user)->delete();
        }
        return redirect()->back()->with('danger', 'Marathon runner  deleted successfully!');
    }
    public function marathon_settings()
    {
        $marathon_settings = AwardMarathonSetting::get()->first();
        return view('admin.marathon.settings')->with(['marathon_settings' => $marathon_settings]);
    }
    public function marathon_settings_store(Request $request)
    {
        $this->validate($request, [
            'marathon_registration' => 'boolean',
            'marathon_registration_time_remain' => 'required|date_format:Y-m-d H:i:s',
        ]);
        $settings = AwardMarathonSetting::updateOrCreate([
            'id' => $request->general_settings_id
        ], [
            'marathon_registration' => $request->marathon_registration,
            'marathon_registration_time_remain' => $request->marathon_registration_time_remain,
        ]);
        if ($settings) {
            return redirect()->back()->with('success', 'Marathon Settings Successfully  Updated!');
        } else {
            return redirect()->back()->with('danger', 'Marathon Settings Fail to Update!');
        }
    }
    public function award_category()
    {

        $award_category = AwardCategory::latest()->get();
        return view('admin.awards.award-category')->with(['award_category' => $award_category]);
    }
    public function award_category_index()
    {
        $award_category = AwardCategory::all();
        return response()->json($award_category);
    }
    public function award_category_add_index()
    {
        return view("admin.awards.award-category-add");
    }
    public function award_category_add(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $general_slug = Str::random(40);

        $i = 0;
        while (AwardCategory::where('slug', $general_slug)->exists()) {
            $i++;
            $general_slug = Hash::make(Str::random(40) . $i);
        }
        AwardCategory::create([
            'slug' => $general_slug,
            'name' => $request->name,
            'name_in_swahili' => $request->name_in_swahili,
            'description' => $request->category_description,
        ]);

        return redirect()->route('admin.award_category')->with('success', 'Award Category Successfully  Added!');
    }
    public function award_category_store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        AwardCategory::updateOrCreate([
            'slug' => $request->award_category_id
        ], [
            'name' => $request->name,
            'name_in_swahili' => $request->name_in_swahili,
            'description' => $request->category_description,
        ]);
        return redirect()->back()->with('success', 'Award Category Successfully  Updated!');
    }
    public function award_category_edit($id)
    {
        $where = array('slug' => $id);
        $award_category  = AwardCategory::where($where)->first();
        return view('admin.awards.award-category-edit')->with(['award_category' => $award_category,]);
    }

    public function award_category_destroy($id)
    {
        $award_category = AwardCategory::where('id', $id)->delete();
        return redirect()->back()->with('danger', 'Award Category successfully  Deleted!');
    }
    public function award_category_destroy_all(Request $request)
    {
        $id = $request->category_id;
        foreach ($id as $user) {
            $deleted = AwardCategory::where('id', $user)->delete();
        }
        return redirect()->back()->with('danger', 'Award Category  deleted successfully!');
    }
    public function award_nominee()
    {
        $id = auth()->user()->id;
        $award_category = AwardCategory::all();

        $currrentYear = date('Y');
        $award_nominees = AwardNominee::with('awardcategory')
            ->whereYear('created_at', '=', $currrentYear)
            ->latest()
            ->get();

        return view('admin.awards.award-nominee')->with(['award_nominees' => $award_nominees, 'award_category' => $award_category]);
    }
    public function awards_nominees_store(Request $request)
    {


        $request->validate([
            'full_name' => 'required|min:3|max:255',
        ]);

        $general_slug = Str::random(40);

        $i = 0;
        while (AwardNominee::where('slug', $general_slug)->exists()) {
            $i++;
            $general_slug = Hash::make(Str::random(40) . $i);
        }
        //check if phonenumber is empty
        if (empty($request->mobile)) {
            $faker = Factory::create();
            $number = $faker->numerify('07########');
            $trimedmobile = substr($number, -9);
            $phonenumber = '255' . $trimedmobile;
        }
        if (!empty($request->mobile)) {
            if ($request->mobile) {
                $request->validate([
                    'mobile' => ['required', 'max:13', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                ]);
                $trimedmobile = substr($request->mobile, -9);
                $phonenumber = '255' . $trimedmobile;
            }
        }
        //Check if email is emapty

        if (empty($request->email)) {
            $faker = Factory::create();
            $email = $faker->unique()->email;
        }
        if (!empty($request->email)) {
            if ($request->email) {
                $request->validate([
                    'email' => ['required', 'max:255',],
                ]);

                $email = $request->email;
            }
        }

        if (empty($request->address)) {

            $address = 'Unknown';
        }
        if (!empty($request->address)) {
            if ($request->address) {
                $request->validate([
                    'address' => ['required', 'max:255',],
                ]);

                $address = $request->address;
            }
        }

        //Check if nominee exist with the sam category
        $currrentYear = date('Y');
        $nominee_exist = AwardNominee::where('email', $request->email)
            ->where('category_id', $request->category_id)
            ->whereYear('created_at', '=', $currrentYear)
            ->first();
        if ($nominee_exist) {
            return redirect()->back()->with('warning', 'You have already registered in this category');
        } else {
            $name = strtoupper($request->full_name);
            $nominees = AwardNominee::create(
                [
                    'slug' => $general_slug,
                    'mobile' => $phonenumber,
                    'email' => $email,
                    'address' =>  $address,
                    'category_id' => $request->category_id,
                    'full_name' => $name,
                    'company_individual' => $request->company_individual,
                    'verified' => $request->verified,
                ]

            );
            return redirect()->back()->with('success', 'Registration Sucessfull !');
        }
    }
    public function award_nominee_edit($id)
    {
        $where = array('id' => $id);
        $award_category  = AwardNominee::where($where)->first();
        return response()->json($award_category, 200);
    }
    public function award_nominee_store(Request $request)
    {


        $nominee = AwardNominee::findOrFail($request->award_nominee_id);

        $request->validate([
            'verified' => ['required', 'boolean', 'max:1'],
        ]);
        $nominee->update([
            'verified' => $request->verified,
        ]);
        if (!empty($request->full_name)) {
            $request->validate([
                'full_name' => 'required|min:3|max:255',
            ]);
            $name = strtoupper($request->full_name);
            $nominee->update([
                'full_name' =>  $name,
            ]);
        }
        if (!empty($request->mobile)) {
            if ($request->mobile != $nominee->mobile) {
                $request->validate([
                    'mobile' => ['required', 'max:13', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                ]);
                $trimedmobile = substr($request->mobile, -9);
                $phonenumber = '255' . $trimedmobile;
                $nominee->update([
                    'mobile' => $phonenumber,
                ]);
            }
        }
        if (!empty($request->email)) {
            if ($request->email != $nominee->email) {
                $request->validate([
                    'email' => ['required', 'max:255'],
                ]);
                $nominee->update([
                    'email' => $request->email,
                ]);
            }
        }
        if (!empty($request->address)) {
            $request->validate([
                'address' => ['required', 'max:255'],
            ]);
            $nominee->update([
                'address' => $request->address,
            ]);
        }
        if (!empty($request->company_individual)) {
            $request->validate([
                'company_individual' => ['required', 'max:255'],
            ]);
            $nominee->update([
                'company_individual' => $request->company_individual,
            ]);
        }

        if (!empty($request->category_id)) {
            $request->validate([
                'category_id' => ['required', 'max:255'],
            ]);
            $nominee->update([
                'category_id' => $request->category_id,
            ]);
        }

        return redirect()->back()->with('success', 'Sucessfull Updated!');
    }
    public function awards_nominees_delete(Request $request)
    {
        $id = $request->category_id;
        foreach ($id as $user) {
            $deleted = AwardNominee::where('id', $user)->delete();
        }
        return redirect()->back()->with('danger', 'Award Nominee  deleted successfully!');
    }



    public function award_settings()
    {
        $marathon_settings = AwardMarathonSetting::get()->first();
        return view('admin.awards.settings')->with(['marathon_settings' => $marathon_settings]);
    }
    public function award_settings_store(Request $request)
    {
        $this->validate($request, [
            'vote' => 'boolean',
            'vote_time_remain' => 'required|date_format:Y-m-d H:i:s',
            'awards_registration' => 'boolean',
            'awards_registration_time_remain' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $settings = AwardMarathonSetting::updateOrCreate([
            'id' => $request->general_settings_id
        ], [
            'vote' => $request->vote,
            'vote_time_remain' => $request->vote_time_remain,
            'awards_registration' => $request->awards_registration,
            'awards_registration_time_remain' => $request->awards_registration_time_remain,
        ]);
        if ($settings) {
            return redirect()->back()->with('success', 'Award Settings Successfully  Updated!');
        } else {
            return redirect()->back()->with('danger', 'Award Settings Fail to Update!');
        }
    }


    public function user_index()
    {
        return view('admin.user_inder');
    }
    public function profile()
    {
        $id = auth()->user()->id;
        $profile = Profile::where('user_id', $id)->first();

        return view('admin.profile')->with('profile', $profile);
    }
    public function site_settings_index()
    {
        $site_settings = GeneralSetting::get()->first();

        return view('admin.settings.site-settings')->with('site_settings', $site_settings);
    }
    public function site_settings_edit($id)
    {
    }
    public function site_settings_store(Request $request)
    {
        $request->validate([
            'site_name' => 'required|min:3',
            'site_tagline' => 'required|min:3',
            'site_url' => 'required|min:3',
        ]);
        $id = $request->general_settings_id;
        $general_settings = GeneralSetting::where('id', $id)->first();
        if (!empty($request->site_icon)) {
            $request->validate([
                'site_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=1/1',
            ]);
            if ($site_icon = $request->file('site_icon')) {
                $destinationPath = 'image/';
                $site_icon_name = 'site_icon_' . date('YmdHis') . "." . $site_icon->getClientOriginalExtension();
                $site_icon->move($destinationPath, $site_icon_name);
                //Check if site icon exist in the folder
                if ($general_settings != null) {
                    $site_icon_file = $destinationPath . '' . $general_settings->site_icon;
                    if (file_exists($site_icon_file)) {
                        @unlink($site_icon_file);
                    }
                }
            }
        }
        if (!empty($request->site_logo)) {
            $request->validate([
                'site_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($site_logo = $request->file('site_logo')) {
                $destinationPath = 'image/';
                $site_logo_name = 'site_logo_' . date('YmdHis') . "." . $site_logo->getClientOriginalExtension();
                $site_logo->move($destinationPath, $site_logo_name);
            }
            //Check if site logo exist in the folder
            if ($general_settings != null) {
                $site_logo_file = $destinationPath . '' . $general_settings->site_logo;
                if (file_exists($site_logo_file)) {
                    @unlink($site_logo_file);
                }
            }
        }
        if ($general_settings == null) {
            $general_slug = Str::random(40);

            $i = 0;
            while (GeneralSetting::where('slug', $general_slug)->exists()) {
                $i++;
                $general_slug = Hash::make(Str::random(40) . $i);
            }
            // Insert new record into database
            $new_record = GeneralSetting::create();
            $new_record->slug = $general_slug;
            $new_record->site_name = $request->site_name;
            $new_record->site_tagline = $request->site_tagline;
            $new_record->site_url = $request->site_url;
            if (!empty($request->site_icon)) {
                $new_record->site_icon = $site_icon_name;
            }
            if (!empty($request->site_logo)) {
                $new_record->site_logo = $site_logo_name;
            }
            $new_record->save();
            return redirect()->back()->with('success', 'Site Settings Data Sucessfull Created!');
        } else {
            // Update the existing record
            $general_settings->update();
            $general_settings->site_name = $request->site_name;
            $general_settings->site_tagline = $request->site_tagline;
            $general_settings->site_url = $request->site_url;
            if (!empty($request->site_icon)) {
                $general_settings->site_icon = $site_icon_name;
            }
            if (!empty($request->site_logo)) {
                $general_settings->site_logo = $site_logo_name;
            }
            $general_settings->save();

            return redirect()->back()->with('warning', 'Site Settings Data Sucessfull Updated!');
        }
    }
    public function site_settings_destroy($id)
    {
    }
    public function payments_settings_index()
    {
        $dpo_settings = DpoGroup::get()->first();
        return view('admin.settings.dpo-group-settings', compact('dpo_settings'));
    }
    public function payments_settings_store(Request $request)
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
        $slug = $request->general_settings_id;
        $dpo_general_settings = DpoGroup::where('slug', $slug)->first();
        $dpo_general_settings->update();
        $dpo_general_settings->enable_dpo           = $request->enable_dpo;
        $dpo_general_settings->dpo_sandbox          = $request->dpo_sandbox;
        $dpo_general_settings->dpo_base_url         = $request->dpo_base_url;
        $dpo_general_settings->dpo_default_currency = strtoupper($request->dpo_default_currency);
        $dpo_general_settings->dpo_default_country  = ucfirst($request->dpo_default_country);
        $dpo_general_settings->dpo_default_service  = $request->dpo_default_service;
        $dpo_general_settings->dpo_default_service_description = ucwords($request->dpo_default_service_description);
        $dpo_general_settings->dpo_company_token    = $request->dpo_company_token;
        $dpo_general_settings->save();
        if ($dpo_general_settings) {
            return redirect()->back()->with('success', 'Dpo Group Services Successfully Updated ');
        } else {
            return redirect()->back()->with('danger', 'There was an error occur during update');
        }
    }
    public function payments_settings_edit($payments)
    {
    }
    public function payments_settings_destroy($payments)
    {
    }
    public function dpo_payments_index()
    {
        $currrentYear = date('Y');
        $payments = PushPayment::whereYear('created_at', '=', $currrentYear)
            ->latest()
            ->get();
        return view('admin.dpo-paymeny.index')->with(['payments' => $payments]);
    }
    public function dpo_payments_index_show($id)
    {
        $where = array('id' => $id);
        $payment  = PushPayment::where('id', $where)->get();
        return response()->json($payment);
    }
    public function dpo_payments_index_view()
    {
        $payments = PushPayment::all();
        return response()->json($payments);
    }
    public function dpo_payments_verify(Request $request)
    {

        $slug = $request->pay_slug;
        // TODO Get Payments Settings
        $row_payment_settings = DpoGroup::first();
        // dd($row_payment_settings);
        $dpo_company_token      = $row_payment_settings->dpo_company_token;
        $payments = PushPayment::where('slug', $slug)->first();
        $transToken = $payments->transactiontoken;
        $data = [];
        $data['companyToken'] = $dpo_company_token;
        $data['transToken'] = $transToken;
        $dpo = new Dpo();
        $verified = $dpo->verifyToken($data);
        $token = $verified['result'];

        $result = $token['Result'];
        $resultexplanation = $token['ResultExplanation'];
        $customername = $token['CustomerName'];
        $customercredit = $token['CustomerCredit'];
        $customercredittype = $token['CustomerCreditType'];
        $transactionapproval = $token['TransactionApproval'];
        $transactioncurrency = $token['TransactionCurrency'];
        $transactionamount = $token['TransactionAmount'];
        $fraudalert = $token['FraudAlert'];
        $fraudexplnation = $token['FraudExplnation'];
        $transactionnetamount = $token['TransactionNetAmount'];
        $transactionsettlementdate = $token['TransactionSettlementDate'];
        $transactionrollingreserveamount = $token['TransactionRollingReserveAmount'];
        $transactionrollingreservedate = $token['TransactionRollingReserveDate'];
        $transactionfinalcurrency = $token['TransactionFinalCurrency'];
        $transactionfinalamount = $token['TransactionFinalAmount'];
        $customerphone = $token['CustomerPhone'];
        $customercountry = $token['CustomerCountry'];
        $customercity = $token['CustomerCity'];
        $customerzip = $token['CustomerZip'];
        $mobilepaymentrequest = $token['MobilePaymentRequest'];
        $accref = $token['AccRef'];
        if ($result == 000) {
            //Paid
            //send SMS to user after complete payment
            $trimedmobile = substr($customerphone, -9);
            $phonenumber = '255' . $trimedmobile;
            $base_url = 'https://messaging-service.co.tz/api/sms/v1/text/single';
            $from = 'SHAMBADUNIA';
            $to = $phonenumber;
            $text = 'Habari ' . $token['CustomerName'] . ' malipo yako ya TZS ' . $token['TransactionAmount'] . ' kwa ajili ya kushiriki kwenye KILIMO MARATHON yamekamilika.Risiti Namba ' . $token['TransactionApproval'] . '. Kwa msaada zaidi piga simu :+255754222800.';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $base_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"from":"' . $from . '", "to":"' . $to . '",  "text": "' . $text . '"}',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic c2hhbWJhZHVuaWE6UFY5Qzk1',
                    'Content-Type: application/json',
                    'Accept: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $error    = curl_error($curl);
            $datafile = json_decode($response, true, JSON_UNESCAPED_SLASHES);;
            curl_close($curl);
            ////////////////////Marathon Update///////////////////////////////////////////////////

            $marathon = MarathonRegistration::where('phone', $phonenumber)
                ->where('paid', '=', '0')
                ->update([
                    'paid' => 1
                ]);
            //////////////////Payment Update///////////////
            $payments->update([
                'result' => $result,
                'resultexplanation' => $resultexplanation,
                'customername' => $customername,
                'customercredit' => $customercredit,
                'customercredittype' => $customercredittype,
                'transactionapproval' => $transactionapproval,
                'transactioncurrency' => $transactioncurrency,
                'transactionamount' => $transactionamount,
                'fraudalert' => $fraudalert,
                'fraudexplnation' => $fraudexplnation,
                'transactionnetamount' => $transactionnetamount,
                'transactionsettlementdate' => $transactionsettlementdate,
                'transactionrollingreserveamount' => $transactionrollingreserveamount,
                'transactionrollingreservedate' => $transactionrollingreservedate,
                'transactionfinalcurrency' => $transactionfinalcurrency,
                'transactionfinalamount' => $transactionfinalamount,
                'customerphone' => $customerphone,
                'customercountry' => $customercountry,
                'customercity' => $customercity,
                'customerzip' => $customerzip,
                'mobilepaymentrequest' => $mobilepaymentrequest,
                'accref' => $accref,
                'status' => 'Paid',
            ]);
            return redirect()->back()->with('success', $payments->resultexplanation);
        } else {
            //OverPaid/underpaid

            $payments->update([
                'result' => $result,
                'resultexplanation' => $resultexplanation,
                'customername' => $customername,
                'customercredit' => $customercredit,
                'transactionapproval' => $transactionapproval,
                'transactioncurrency' => $transactioncurrency,
                'transactionamount' => $transactionamount,
                'fraudalert' => $fraudalert,
                'fraudexplnation' => $fraudexplnation,
                'transactionnetamount' => $transactionnetamount,
                'transactionsettlementdate' => $transactionsettlementdate,
                'transactionrollingreserveamount' => $transactionrollingreserveamount,
                'transactionrollingreservedate' => $transactionrollingreservedate,
                'transactionfinalcurrency' => $transactionfinalcurrency,
                'transactionfinalamount' => $transactionfinalamount,
                'customerphone' => $customerphone,
                'customercountry' => $customercountry,
                'customercity' => $customercity,
                'customerzip' => $customerzip,
                'mobilepaymentrequest' => $mobilepaymentrequest,
                'accref' => $accref,
                'customercredittype' => $customercredittype,
                'status' => 'Not Paid',
            ]);
            return redirect()->back()->with('warning', $payments->resultexplanation);
        }
    }

    public function send_sms()
    {
        $currrentYear = date('Y');
        $award_nominees = AwardNominee::where('Verified', '=', '1')
            ->whereYear('created_at', '=', $currrentYear)
            ->orderBy('id', 'asc')
            ->get();

        foreach ($award_nominees as $award) {
            $mobile = $award->mobile;
            $name = $award->full_name;

            //send SMS to user after complete payment
            $trimedmobile = substr($mobile, -9);
            $phonenumber = '255' . $trimedmobile;
            $base_url = 'https://messaging-service.co.tz/api/sms/v1/text/single';
            $from = 'SHAMBADUNIA';
            $to = $phonenumber;
            $text = 'Habari, SHAMBADUNIA LIMITED kwa niaba ya kamati ya maandalizi ya KILIMO MARATHON, AWARD & EXPO 2022, Tunapenda kukutaarifu kuwa tarehe ya tukio itakuwa kuanzia Tarehe 29 Septemba hadi 1 Oktoba 2022, Katika Uwanja wa Jamhuri badala ya Tarehe 1-3 Septemba. Kwa Mawasiliano Tupigie 0766300777';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $base_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"from":"' . $from . '", "to":"' . $to . '",  "text": "' . $text . '"}',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic c2hhbWJhZHVuaWE6UFY5Qzk1',
                    'Content-Type: application/json',
                    'Accept: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $error    = curl_error($curl);
            $datafile = json_decode($response, true, JSON_UNESCAPED_SLASHES);;
            curl_close($curl);
            dd($datafile);
        }




    }
}
