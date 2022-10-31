<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_us = ContactUs::latest()->get();
        return view('admin.contact-us.index',compact('contact_us'));
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
        $contact = ContactUs::where('id', $request->contact_id)->first();
        $contact->update([
            'seen_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Contact Marked to Seen!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $contactUs = ContactUs::where('id', $request->id)->first() ?? abort(404);
        $delete = $contactUs->delete();
        return redirect()->back()->with('danger', 'Contact successfully Deleted!');
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->contact_id;
        if (!$ids) {
            return redirect()->back();
        }
        ContactUs::where('id', $ids)->delete();
        return redirect()->back()->with('danger', 'Contact deleted successfully!');
    }
}
