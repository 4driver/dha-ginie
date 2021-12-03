<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Users\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Models\Service;
use App\Models\User;

class UserController extends BaseController
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
        $users = User::with(['permissions','services'])->orderBy('id','desc')->paginate(10);
        return $this->sendResponse($users, 'Success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
        ]);

        if ($request->has('permission')) {
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $user->permissions()->attach($permissions);
        }

        if ($request->has('service')) {
            $services = Service::whereIn('id', $request->service)->get();
            $user->services()->attach($services);
        }

        return $this->sendResponse($user, 'User Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, $id)
    {
        // dd($request->all());

        $user = User::findOrFail($id);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }


        if ($request->has('permission')) {
            $user->permissions()->detach();
            $permissions = User::whereIn('id', $request->permission)->get();
            $user->permissions()->attach($permissions);
        }

        if ($request->has('selectedServices')) {
            $ids = array_column($request->selectedServices, 'id');
            $user->services()->detach();
            // $services = Service::whereIn('id', $ids)->get();
            $user->services()->attach($ids);
        }

        $user->update($request->all());

        return $this->sendResponse($user, 'User Information has been updated');
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
        $user = User::findOrFail($id);
        $user->delete();
        return $this->sendResponse([$user], 'User has been Deleted');
    }

    public function getVendorsList()
    {
        $vendors = User::where('type','vendor')->orderBy('name','asc')->get();
        return $this->sendResponse($vendors, 'Success');
    }

    public function getSelectedServices()
    {
        // dd($id);
        $servcies = Service::select('id','name')->orderBy('name','asc')->take(3)->get()->toArray();
        return $this->sendResponse($servcies, 'Success');
    }
}
