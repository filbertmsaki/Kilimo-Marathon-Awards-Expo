<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\AwardRequest;
use App\Models\AwardCategory;
use App\Models\AwardNominee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Symfony\Component\HttpFoundation\Response;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.event.award.index');
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

    public function getStatus()
    {
        if (FacadesRequest::is('api*')) {
            if (!isAwardActive()) {
                return response()->json('Award Registaration is cloded for now, please try again latter!.', Response::HTTP_NOT_FOUND);
            }
            return response()->json('Award Registaration is now open, you may now proceed to another steps!.', Response::HTTP_FOUND);
        }
        abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AwardRequest $request)
    {
        if (FacadesRequest::is('api*')) {
            if (!isAwardActive()) {
                return response()->json('Award Registaration is cloded for now, please try again latter!.', Response::HTTP_NOT_FOUND);
            }
            $award_category = AwardCategory::where('name', $request->category_id)->first();
            if ($award_category == null) {
                return response()->json('The award category does not exist.', Response::HTTP_NOT_FOUND);
            }
            $request->merge([
                'category_id' => $award_category->id
            ]);
        }
        if (!isAwardActive()) {
            abort(404);
        }
        $exist = AwardNominee::nomineeExist(
            $request->company_name,
            $request->category_id
        );
        if ($exist) {
            if (FacadesRequest::is('api*')) {
                return response()->json('You have already registered in this category, please wait to be verified!',Response::HTTP_FOUND);
            }
            return redirect()->back()->with('warning', 'You have already registered in this category, please wait to be verified!');
        }
        DB::beginTransaction();
        AwardNominee::create($request->except('_token'));
        DB::commit();
        if (FacadesRequest::is('api*')) {
            return response()->json('You have successful register to kilimo awards.',  Response::HTTP_CREATED);
        }
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
        abort(401);
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
    public function registration()
    {
        if (!isAwardActive()) {
            abort(404);
        }
        return view('web.event.award.registration');
    }
    public function category()
    {
        $categories = AwardCategory::orderBy('name', 'ASC')->paginate(16);
        return view('web.event.award.category', compact('categories'));
    }
    public function categoryShow($slug)
    {
        $category = AwardCategory::where('slug', $slug)->first() ?? abort(404);
        return view('web.event.award.category-show', compact('category'));
    }
}
