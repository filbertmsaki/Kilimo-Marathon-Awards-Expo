<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarathonRequest;
use App\Models\AwardMarathonSetting;
use App\Models\MarathonRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class MarathonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currrentYear = date('Y');
        $runners = MarathonRegistration::whereYear('created_at', '=', $currrentYear)
            ->latest()
            ->get();
        return view('admin.events.marathon.index', compact('runners'));
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
    public function store(MarathonRequest $request)
    {
        DB::beginTransaction();
        MarathonRegistration::create($request->except('_token'));
        DB::commit();
        return redirect()->back()->with('success', 'Marathon runner successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $runners = MarathonRegistration::whereYear('created_at', '=', $id)
            ->latest()
            ->get();

        return $runners;
    }

    public function runners($id)
    {

        $runners = MarathonRegistration::whereYear('created_at', '=', $id)
            ->latest()
            ->get();
        if ($runners->count() == 0) {
            abort(404);
        }
        return view('admin.events.marathon.runners-list', compact('runners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $runners  = MarathonRegistration::where('id', $id)->first();
        return response()->json($runners, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MarathonRequest $request, $id)
    {
        $marathon_runner_id  = $request->marathon_runner_id;
        DB::beginTransaction();
        $marathon_runner = MarathonRegistration::where('id', $marathon_runner_id)->first() ?? abort(404);
        $marathon_runner->update($request->except('_token', '_method'));
        DB::commit();
        return redirect()->back()->with('success', 'Marathon runner successfully Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $runner = MarathonRegistration::where('id', $request->id)->first() ?? abort(404);
        $delete = $runner->delete();
        return redirect()->back()->with('danger', 'Marathon runner successfully Deleted!');
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->runner_id;
        if (!$ids) {
            return redirect()->back();
        }
        MarathonRegistration::where('id', $ids)->delete();
        return redirect()->back()->with('danger', 'Marathon runner  deleted successfully!');
    }
    public function settingIndex()
    {
        $marathon_settings = AwardMarathonSetting::get()->first();
        return view('admin.events.marathon.settings', compact('marathon_settings'));
    }
    public function settingStore(Request $request)
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
}
