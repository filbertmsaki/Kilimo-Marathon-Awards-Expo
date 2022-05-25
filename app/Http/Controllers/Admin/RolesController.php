<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:admin']);
    }
    public function index()
    {
        abort_if(Gate::denies('access-roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();
        
           
        return view('admin.user.roles', compact('roles'));
    }

    public function roleindex()
    {

        $roles = Role::all();
        return response()->json($roles);
    }

    public function edit($id)
    {
        abort_if(Gate::denies('edit-roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $where = array('id' => $id);
        $role  = Role::where($where)->get();
        $role->load(['permissions','users']);
        return response()->json(['roles'=>$role]);
    }

    public function store(Request $request){
        abort_if(Gate::denies('edit-roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => ['required', 'string'],
          ]);
        // $role->permissions()->sync($request->input('permissions', []));
        if(empty($request->role_id)){
            $slug = str_replace(' ', '-',$request->name);
            $role = Role::create([
                'name' => $request->name,
                'slug' => strtolower($slug),
            ]);
        }else{
            $role= Role::where('id',$request->role_id)->first();
            $role->update(['name' => $request->name,]);
 
        }
     
        if(empty($request->role_id)){
          
            return response()->json(['success','Sucessfull Added!', 200]); 
             

        }else{
            return response()->json(['success','Role '. $role->name.' Updated!', 200]); 

        }


    }

    public function destroy($id){
        abort_if(Gate::denies('delete-roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Role::where('id',$id)->delete();
        return response()->json(['danger','Role  Deleted!', 200]); 

    }
    public function destroy_all(Request $request){
        abort_if(Gate::denies('delete-roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->ids;
        DB::table("roles")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Role Deleted successfully."]);
    }
}
