<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignmentRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Booking;
use App\Models\User;

class AssignmentController extends BaseController
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
        $bookings = Booking::with(['vendors','service' => function ($query) {
            return $query->select('id','name');
        }])->orderBy('id','desc')->paginate(10);
        return $this->sendResponse($bookings, 'success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
    public function update(AssignmentRequest $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($request->has('vendor_id')) {
            $booking->vendors()->detach();
            $vendors = array_column($request->vendor_id, 'id');
            $booking->vendors()->attach($vendors);
        }

        return $this->sendResponse($booking, 'Record updated successfully.');
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
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return $this->sendResponse([$booking], 'Record has been deleted');
    }

    public function getSelectedVendors($id)
    {
        $booking = Booking::with(['vendors' => function ($query) {
           return $query->select('users.id','users.name');
        }])->find($id);

        $vendors = $booking->vendors->toArray();

        return $this->sendResponse($vendors, 'Success');
    }
}
