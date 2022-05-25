<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermisionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:admin']);
    }
    public function index()
    {
        abort_if(Gate::denies('access-permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all();
           
        return view('admin.user.permissions', compact('permissions'));
    }

    public function permissionindex()
    {

        $permissions = Permission::all();
        return response()->json($permissions);
    }

 

    public function edit($id)
    {
        abort_if(Gate::denies('edit-permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $where = array('id' => $id);
        $permissions  = Permission::where($where)->get();
        $permissions->load(['roles','users']);
        return response()->json(['permissions'=>$permissions]);
    }

    public function store(Request $request){
        abort_if(Gate::denies('edit-permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => ['required', 'string'],
          ]);
        // $permissions->permissions()->sync($request->input('permissions', []));
        if(empty($request->permission_id)){
            $slug = str_replace(' ', '-',$request->name);
            $permissions = Permission::create([
                'name' => $request->name,
                'slug' => strtolower($slug),
            ]);
        }else{
            $permissions= Permission::where('id',$request->permission_id)->first();
            $permissions->update(['name' => $request->name,]);
 
        }
     
        if(empty($request->permission_id)){
          
            return response()->json(['success','Sucessfull Added!', 200]); 
             

        }else{
            return response()->json(['success','Role '. $permissions->name.' Updated!', 200]); 

        }


    }

    public function destroy($id){
        abort_if(Gate::denies('delete-permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Permission::where('id',$id)->delete();
        return response()->json(['danger','Role  Deleted!', 200]); 

    }
    public function destroy_all(Request $request){
        abort_if(Gate::denies('delete-permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ids = $request->ids;
        DB::table("permissions")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Role Deleted successfully."]);
    }
}
