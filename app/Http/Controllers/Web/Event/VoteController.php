<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Models\AwardCategory;
use App\Models\AwardNominee;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jorenvh\Share\Share;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isVoteActive()) {
            return redirect()->route('web.index');
        }
        $currrentYear = date('Y');
        $nominees = AwardNominee::with('awardcategory')
            ->with('awardcategory')
            ->where('Verified', '=', '1')
            ->whereYear('created_at', '=', $currrentYear)
            ->groupBy('category_id')
            ->orderBy(DB::raw('COUNT(id)', 'asc'))
            ->get(array(DB::raw('COUNT(id) as total_nominee'), 'category_id'))
            ->sortBy('awardcategory.name', SORT_REGULAR, false);

        return view('web.event.vote.index', compact('nominees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(401);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!isVoteActive()) {
            abort(404);
        }
        $agent = request()->header("User-Agent") . ' ' . request()->ip();
        $nominee = AwardNominee::where('slug', $request->nominee)->first() ?? abort(404);
        $vote = Vote::where([
            'category_id' => $nominee->awardcategory->id,
            'agent' => $agent,
        ])->where('created_at', ">=", Carbon::now()->subHours(12)->format("Y-m-d H:i:s"));

        if ($vote->count() <= 0) {
            Vote::create([
                'nominee_id' =>  $nominee->id,
                'category_id' => $nominee->awardcategory->id,
                'agent' => $agent
            ]);
            return response()->json(['success' => trans('vote.notification.success',['name'=>$nominee->company_name, 'category'=>$nominee->awardcategory->name])]);
        }
        $voted = Vote::where([
            'agent' => $agent,
            'category_id' => $nominee->awardcategory->id
        ])->first();
        $nominee_voted = AwardNominee::where('id', $voted->nominee_id)->first();
        return response()->json(['error' => trans('vote.notification.error',['name'=>$nominee_voted->company_name])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!isVoteActive()) {
            abort(404);
        }
        $currrentYear = date('Y');
        $category = AwardCategory::where('slug', $id)->latest()->first();
        $nominees = AwardNominee::select('slug as data_id', 'company_name as data_name')
            ->where('Verified', '=', '1')
            ->where('category_id', '=', $category->id)
            ->whereYear('created_at', '=', $currrentYear)
            ->orderBy('company_name', 'asc')
            ->get();
        $share = new Share();
        $share->currentPage('Please vote for me as a ' . '' . $category->name)
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp();
        return view('web.event.vote.show', compact('nominees', 'category', 'share'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(401);

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
        abort(401);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(401);

    }
}
