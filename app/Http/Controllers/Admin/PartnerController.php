<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.partner.index', compact('partners'));
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
            'order' => ['required','unique:partners'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',

        ]);
        $fileName = '';
        if ($file = $request->file('image')) {
            $path = 'images/partners/' . date('Y') . '/' . date('m') . '/';

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $fileName = $path . strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $request->name))) . "-" . date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $request->merge([
                'image_url' => $fileName,
            ]);
        }
        Partner::create($request->except(['_token', 'image',]));
        return redirect()->back()->with('success', 'Partner successfully created!');
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
        $partner = Partner::where('slug', $request->partner_id)->first() ?? abort(404);
        $fileName = $partner->image_url;


        if ($file = $request->file('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);
            $path = 'images/partners/' . date('Y') . '/' . date('m') . '/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $fileName = $path . strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $request->name))) . "-" . date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $request->merge([
                'image_url' => $fileName,
            ]);
            if (file_exists(public_path($fileName))) {
                unlink($fileName);
            }
        }
        $partner->update($request->except(['_token', 'image', '_method']));
        return redirect()->back()->with('success', 'Partner successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $partner = Partner::where('id', $request->id)->first() ?? abort(404);
        $delete = $partner->delete();
        if ($delete) {
            $image_name = $partner->image_url;
            if (file_exists(public_path($image_name))) {
                unlink($image_name);
            }
        }
        return redirect()->back()->with('danger', 'Partner successfully Deleted!');
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->partner_id;
        if (!$ids) {
            return redirect()->back();
        }
        Partner::whereIn('id', $ids)->delete();
        return redirect()->back()->with('danger', 'Partner deleted successfully!');
    }
}
