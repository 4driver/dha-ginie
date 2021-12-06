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

        $user = User::create($request->validated());
        $user->update(['password' => Hash::make($request['password'])]);

        if ($request->has('permission') && $request->type == 'admin') {
            $permissions = array_column($request->permission, 'id');
            $user->permissions()->attach($permissions);
        }

        if ($request->has('service') && $request->type == 'vendor') {
            $services = array_column($request->service, 'id');
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
        $user = User::findOrFail($id);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        if ($request->has('permission') && $request->type == 'admin') {
            $user->permissions()->detach();
            $permissions = array_column($request->permission, 'id');
            $user->permissions()->attach($permissions);
        }

        if ($request->has('service') && $request->type == 'vendor') {
            $services = array_column($request->service, 'id');
            $user->services()->detach();
            $user->services()->attach($services);
        }

        if ($request->type == 'admin') {
            $user->services()->detach();
        }

        if ($request->type == 'vendor') {
            $user->permissions()->detach();
        }

        $user->update($request->validated());

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

    public function getSelectedServices($id)
    {
        $user = User::with(['services' => function ($query) {
           return $query->select('services.id','services.name');
        }])->find($id);

        $servcies = $user->services->toArray();

        return $this->sendResponse($servcies, 'Success');
    }

    public function getSelectedPermissions($id)
    {
        $user = User::with(['permissions' => function ($query) {
           return $query->select('permissions.id','permissions.name');
        }])->find($id);

        $permissions = $user->permissions->toArray();

        return $this->sendResponse($permissions, 'Success');
    }
}
