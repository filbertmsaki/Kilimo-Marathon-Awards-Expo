<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.user.index', compact('users'));
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
    public function rolePermision()
    {
        $permissions = Permission::with(['users', 'roles'])->get();
        $roles = Role::with(['users', 'permissions'])->get();
        return response()->json(['roles' => $roles, 'permissions' => $permissions]);
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


        $user = User::where('id', $request->user_id)->first();
        if (!($request->email == $user->email)) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }
        if (!($request->mobile == $user->mobile)) {
            $request->validate([
                'mobile' => ['required', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'unique:users'],
            ]);
        }

        if (!empty($request->first_name)) {
            $request->validate([
                'first_name' => ['required', 'string'],
            ]);
        }

        if (!empty($request->last_name)) {
            $request->validate([
                'last_name' => ['required', 'string'],
            ]);
        }

        $request->validate([

            'role_id' => ['required', 'max:1'],
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!empty($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $user->roles()->sync($request->role_id);
        $user->permissions()->sync($request->permission_id);

        return redirect()->back()->with('success','User successful updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        User::where('id', $id)->delete();
        return response()->json(['danger', 'User  Deleted!', 200]);
    }
    public function destroy_all(Request $request)
    {
        abort_if(Gate::denies('delete-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->ids;
        DB::table("users")->whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "User Deleted successfully."]);
    }
}
