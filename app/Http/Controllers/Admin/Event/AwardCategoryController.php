<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Models\AwardCategory;
use Illuminate\Http\Request;

class AwardCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = AwardCategory::latest()->get();
        return view('admin.events.award.category', compact('categories'));
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
            'name' => ['required', 'string', 'max:255'],
        ]);
        AwardCategory::create([
            'name' => $request->name,
            'name_in_swahili' => $request->name_in_swahili,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('success', 'Award Category Successfully  Added!');
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        AwardCategory::updateOrCreate([
            'slug' => $request->category_id
        ], [
            'name' => $request->name,
            'name_in_swahili' => $request->name_in_swahili,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('success', 'Award Category Successfully  Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $runner = AwardCategory::where('slug', $request->id)->first() ?? abort(404);
        $delete = $runner->delete();
        return redirect()->back()->with('danger', 'Category successfully  Deleted!');
    }

    public function destroyAll(Request $request)
    {
        $ids = $request->category_id;
        if (!$ids) {
            return redirect()->back();
        }
        AwardCategory::whereIn('id', $ids)->delete();
        return redirect()->back()->with('danger', 'Category  deleted successfully!');
    }
}
