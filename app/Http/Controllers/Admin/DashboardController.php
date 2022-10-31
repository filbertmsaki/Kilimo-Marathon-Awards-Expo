<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AwardCategory;
use App\Models\AwardNominee;
use App\Models\MarathonRegistration;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currrentYear = date('Y');
        $nominees_count = AwardNominee::where('verified', 1)
            ->whereYear('created_at', '=', $currrentYear)
            ->count();
        $categories_count = AwardCategory::count();
        $runners_count = MarathonRegistration::whereYear('created_at', '=', $currrentYear)
            ->whereYear('created_at', '=', $currrentYear)
            ->count();
        $subscribers_count = Subscriber::count();
      
        return view('admin.index', compact(
            'nominees_count',
            'categories_count',
            'runners_count',
            'subscribers_count',
        ));
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
        //
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
