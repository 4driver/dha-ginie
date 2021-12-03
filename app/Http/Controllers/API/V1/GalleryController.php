<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GalleryRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use App\Models\Gallery;

class GalleryController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }

        $galleries = Gallery::latest()->paginate(10);

        return $this->sendResponse($galleries, 'Success');
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
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required'
        ]);

        if($request->image){
            if (!file_exists('uploads')) {
                mkdir('uploads', 666, true);
            }
            $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
            \Image::make($request->image)->save('uploads/'.$name);
            $request->merge(['image' => $name]);
        }

        $gallery = new Gallery;
        $gallery->title = $request->title;
        $gallery->image = $name;
        $gallery->save();

        return $this->sendResponse($gallery, 'Record added successfully.');
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
        $gallery = Gallery::find($id);

        $this->validate($request, [
            'title' => 'required',
            'image' => 'nullable'
        ]);


        if($request->image && ($gallery->image != $request->image)){
            $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
            \Image::make($request->image)->save(public_path('uploads/').$name);
            $request->merge(['image' => $name]);
            $gallery->image = $name;
        }

        $gallery->title = $request->title;
        $gallery->save();

        return $this->sendResponse($gallery, 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return $this->sendResponse([$gallery], 'Record has been deleted');
    }
}
