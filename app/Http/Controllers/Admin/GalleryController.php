<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        return view('admin.gallery.index', compact('galleries'));
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
            'title' => ['required', 'string', 'max:255'],
            'event' => ['required', 'string', 'max:255'],
        ]);
        $image_name = '';
        if ($gallery_image = $request->file('image')) {
            $path = 'images/gallery/' . date('Y') . '/' . date('m') . '/';

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $image_name = $path . strtolower($request->event) . "-" . date('YmdHis') . "." . $gallery_image->getClientOriginalExtension();
            $gallery_image->move($path, $image_name);
            $request->merge([
                'image_url' => $image_name,
            ]);
        }
        Gallery::create($request->except(['_token', 'image',]));
        return redirect()->back()->with('success', 'Gallery successfully created!');
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
            'title' => ['required', 'string', 'max:255'],
            'event' => ['required', 'string', 'max:255'],
        ]);
        $gallery = Gallery::where('slug', $request->gallery_id)->first() ?? abort(404);
        $image_name = $gallery->image_url;


        if ($gallery_image = $request->file('image')) {
            $path = 'images/gallery/' . date('Y') . '/' . date('m') . '/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $image_name = $path . strtolower($request->event) . "-" . date('YmdHis') . "." . $gallery_image->getClientOriginalExtension();
            $gallery_image->move($path, $image_name);
            $request->merge([
                'image_url' => $image_name,
            ]);
            if (file_exists(public_path($image_name))) {
                unlink($image_name);
            }
        }
        $gallery->update($request->except(['_token', 'image', '_method']));
        return redirect()->back()->with('success', 'Gallery successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $gallery = Gallery::where('id', $request->id)->first() ?? abort(404);
        $delete = $gallery->delete();
        if ($delete) {
            $image_name = $gallery->image_url;
            if (file_exists(public_path($image_name))) {
                unlink($image_name);
            }
        }
        return redirect()->back()->with('danger', 'Gallery successfully Deleted!');
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->gallery_id;
        if (!$ids) {
            return redirect()->back();
        }
        Gallery::whereIn('id', $ids)->delete();
        return redirect()->back()->with('danger', 'Gallery deleted successfully!');
    }
}
