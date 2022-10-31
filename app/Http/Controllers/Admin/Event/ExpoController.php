<?php
namespace App\Http\Controllers\Admin\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpoRequest;
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
        $currrentYear = date('Y');
        $expoModels = ExpoRegistration::whereYear('created_at', '=', $currrentYear)
            ->latest()
            ->get();
        return view('admin.events.expo.index', compact('expoModels'));
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
        ExpoRegistration::create($request->except('_token'));
        DB::commit();
        return redirect()->back()->with('success', 'Sucessfull Created!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expoModels = ExpoRegistration::whereYear('created_at', '=', $id)
            ->latest()
            ->get();
        return view('admin.events.expo.show', compact('expoModels','id'));
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
    public function update(ExpoRequest $request, $id)
    {
        $expo_id                 = $request->expo_id;
        $expo = ExpoRegistration::where('id', $expo_id)->first() ?? abort(404);
        $expo->update($request->except(['_token', '_method', 'expo_id']));
        return redirect()->back()->with('success', 'Expo successfully Updated!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $expo = ExpoRegistration::where('id', $request->id)->first() ?? abort(404);
        $delete = $expo->delete();
        return redirect()->back()->with('danger', 'Expo successfully Deleted!');
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->expo_id;
        if (!$ids) {
            return redirect()->back();
        }
        ExpoRegistration::whereIn('id', $ids)->delete();
        return redirect()->back()->with('danger', 'Expo deleted successfully!');
    }
    public function settingIndex()
    {
        return view('admin.events.expo.settings');
    }
    public function settingStore(Request $request)
    {
    }
}
