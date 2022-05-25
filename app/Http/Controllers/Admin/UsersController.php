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
use Illuminate\Support\Str;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:admin']);
    }
    public function index()
    {

        abort_if(Gate::denies('access-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.user.users');
    }
    public function users_index()
    {
        abort_if(Gate::denies('access-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::with(['roles'])->get();
        return response()->json($users);
    }
    public function roles_permissions()
    {
        abort_if(Gate::denies('access-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions=Permission::with(['users','roles'])->get();
        $roles = Role::with(['users','permissions'])->get();
        return response()->json(['roles'=>$roles,'permissions'=>$permissions]);
    }


    public function edit($id)
    {
        abort_if(Gate::denies('edit-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $where = array('id' => $id);
        $user  = User::where('id',$where)->get();
        $user->load(['permissions','roles']);

        $permissions=Permission::with(['users','roles'])->get();
        $roles = Role::with(['users','permissions'])->get();
        return response()->json(['users'=>$user,'roles'=>$roles,'permissions'=>$permissions]);
    }

    public function store(Request $request){
        abort_if(Gate::denies('edit-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(empty($request->user_id)){
            $request->validate([
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'mobile' => ['required','max:12','regex:/^([0-9\s\-\+\(\)]*)$/' ,'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $username =strtolower( $first_name. $last_name);
            $i = 0;
            while(User::where('name',$username)->exists())
            {
                $i++;
                $username = strtolower( $first_name. $last_name. $i);
            }
            $slug = Str::random(40);
            $i = 0;
            $i = 0;
            while(User::where('slug',$slug)->exists())
            {
                $i++;
                $slug = Hash::make(Str::random(40).$i);
            }
            $user = User::create([
                'slug' => $slug,
                'name' => $username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => Hash::make($request->password),
        
            ]);
            $user->roles()->attach($request->role_id);
            $user->permissions()->attach($request->permission_id);
        }
        else{
            
            $user= User::where('id',$request->user_id)->first();
            if(!($request->email == $user->email)){
                $request->validate([
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                ]);
            }
            if(!($request->mobile == $user->mobile)){
                $request->validate([
                    'mobile' => ['required','max:12','regex:/^([0-9\s\-\+\(\)]*)$/' ,'unique:users'],
                ]);
            }
            if(!empty($request->password)){
                $request->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
            }
            if(!empty($request->first_name)){
                $request->validate([
                    'first_name' => ['required', 'string'],
                ]);
            }

            if(!empty($request->last_name)){
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
        
            $user->roles()->sync($request->role_id);
            $user->permissions()->sync($request->permission_id);

        }
        if(empty($request->user_id)){
            return response()->json(['success','Sucessfull Added!', 200]); 
        }
        else{
            return response()->json(['success','User '. $user->name.' Updated!', 200]); 
        }
    }

    public function destroy($id){
        abort_if(Gate::denies('delete-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        User::where('id',$id)->delete();
        return response()->json(['danger','User  Deleted!', 200]); 

    }
    public function destroy_all(Request $request){
        abort_if(Gate::denies('delete-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->ids;
        DB::table("users")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"User Deleted successfully."]);
    }
}
