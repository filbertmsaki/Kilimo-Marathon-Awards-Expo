<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Redirect,Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    public function user_index(){
     
        $id = auth()->user()->id;
        $profile = Profile::where('user_id',$id)->first();
        $roles = Role::all();
        return view('admin.user.index')->with(['roles'=>$roles,'profile'=>$profile]);
    }
    public function user_store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required','max:12','regex:/^([0-9\s\-\+\(\)]*)$/' ,'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    


    }
    public function user_edit(){
        return view('admin.user.index');
    }


    public function profile_update(Request $request){

        if($request->has('user_data')){
            $request->validate([
                'first_name' =>'required|min:3|max:255',
                'last_name' =>'required|min:3|max:255',
                'address' =>'required|min:3',
                'mobile' => ['required','max:12','regex:/^([0-9\s\-\+\(\)]*)$/' ],
               
                
            ]);
            if($request->current_password ){
                $request->validate([
                    'current_password' => 'required',
                    'password' => 'required|string|min:6',
                    'password_confirmation' => 'required',
                ]);


                $hashedPassword = auth()->user()->password;
                if (Hash::check($request->current_password , $hashedPassword)) {
                    if (!Hash::check($request->password , $hashedPassword)) {
         
                        $users = User::find(auth()->user()->id);
                        $users->password = Hash::make($request->password);
                        $users->save();
                        return redirect()->back()->with('success','password updated successfully!');
                    }
                    else{
                        return redirect()->back()->with('warning','new password can not be the old password!');
                    } 
                }
                else{
                    return redirect()->back()->with('warning','old password doesnt matched!');
                }
            }
            if($request->has('photo')){
                $request->validate([
                    'photo' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=1/1',
                ]);
                if ($image = $request->file('photo')) {
                    $destinationPath = 'image/';
                    $profileImage = 'user_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                }
                $id = auth()->user()->id;
                $user_profile = User::where('id',$id)->first();
                if( $user_profile != null){
                    $file =$destinationPath.''.$user_profile->photo;
                    if(file_exists( $file)){
                        @unlink( $file);
                    }
                }
                $id = auth()->user()->id;
                $user = User::findOrFail($id);
                $user->fill(
                    [
                        'photo' =>$profileImage,    
                    ]
                )->save();

            }

            
            $id = auth()->user()->id;
            $user = User::findOrFail($id);
            $user->fill(
                [
                    'first_name' =>$request->first_name,
                    'last_name' =>$request->last_name,
                    'mobile' =>$request->mobile,
                    'address' =>$request->address,

                ]
            )->save();
        

           

        }

        if($request->has('user_data_info')){
            $request->validate([
                'education' =>'required|min:3',
                'job_title' =>'required|min:3',
                'skills' =>'required|min:3',
                'notes' =>'required|min:3',
            ]);
           

            
            $profile = Profile::where('user_id',auth()->id())->first();
            $profileslug = Str::random(40);
            $i = 0;
            while(Profile::where('slug',$profileslug)->exists())
            {
                $i++;
                $profileslug = Hash::make(Str::random(40).$i);
            }
            if ($profile == null) {
                // Insert new record into database
               $p= Profile::create([
                'slug'      =>$profileslug,
                'user_id'   =>auth()->id(),
                'education' =>$request->education,
                'job_title' =>$request->job_title,
                'skills'    =>$request->skills,
                'notes'     =>$request->notes,
                ]);
            } else {
                // Update the existing record
                $profile->update([
                    'education' =>$request->education,
                    'job_title' =>$request->job_title,
                    'skills' =>$request->skills,
                    'notes' =>$request->notes,
                ]);
            }
        }
        return redirect()->back()->with('success','User Data Sucessfull Updated!');
    }
    //Functions for store roles
    public function role_store(Request $request){
            $request->validate([
                'name'=> 'required|min:3|max:255|unique:roles'
            ]);
            Role::updateOrCreate([
                'id' => $request->role_id
              ],[
                'name' => $request->name,
            ]);
        return redirect()->back()->with('success','User Role Sucessfull Added!');   
    }

    public function role_edit($id){
        $where = array('id' => $id);
        $role  = Role::where($where)->first();
        return response()->json($role, 200);

    }
    public function route_update(Request $request, $id){

    }
    public function role_destroy($id){
        $role = Role::where('id',$id)->delete();
        return response()->json([
            'data' => $role,
            'danger' => 'Data deleted successfully!'
          ]);
    }
}
