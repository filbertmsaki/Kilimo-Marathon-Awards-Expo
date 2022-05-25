<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DammyData extends Controller
{
    

    public function Permission()
    {   
    	$access_users_role_permission = Permission::where('slug','access-users')->first();
		$edit_users_role_permission = Permission::where('slug', 'edit-users')->first();
		$delete_users = Permission::where('slug', 'delete-users')->first();
		$add_users = Permission::where('slug', 'add-users')->first();
		//RoleTableSeeder.php

		$user_role = new Role();
		$user_role->slug = 'user';
		$user_role->name = 'USER ROLE';
		$user_role->save();
		$user_role->permissions()->attach($access_users_role_permission);

		$staff_role = new Role();
		$staff_role->slug = 'staff';
		$staff_role->name = 'STAFF ROLE';
		$staff_role->save();
		$staff_role->permissions()->attach($access_users_role_permission);


		$admin_role = new Role();
		$admin_role->slug = 'admin';
		$admin_role->name = 'ADMIN ROLE';
		$admin_role->save();
		$admin_role->permissions()->attach($edit_users_role_permission);

		$add_user_role = Role::where('slug','user')->first();
		$add_admin_to_role = Role::where('slug', 'admin')->first();
		//User Permission
			$access_users_permission = new Permission();
			$access_users_permission->slug = 'access-users';
			$access_users_permission->name = 'Access Users';
			$access_users_permission->save();
			$access_users_permission->roles()->attach($add_admin_to_role);

			$add_users_permission = new Permission();
			$add_users_permission->slug = 'add-users';
			$add_users_permission->name = 'Add Users';
			$add_users_permission->save();
			$add_users_permission->roles()->attach($add_admin_to_role);

			$edit_users_permission = new Permission();
			$edit_users_permission->slug = 'edit-users';
			$edit_users_permission->name = 'Edit Users';
			$edit_users_permission->save();
			$edit_users_permission->roles()->attach($add_admin_to_role);

			$delete_users_permission = new Permission();
			$delete_users_permission->slug = 'delete-users';
			$delete_users_permission->name = 'Delete Users';
			$delete_users_permission->save();
			$delete_users_permission->roles()->attach($add_admin_to_role);
		//Role Permission
			$access_roles_permission = new Permission();
			$access_roles_permission->slug = 'access-roles';
			$access_roles_permission->name = 'Access Roles';
			$access_roles_permission->save();
			$access_roles_permission->roles()->attach($add_admin_to_role);

			$add_roles_permission = new Permission();
			$add_roles_permission->slug = 'add-roles';
			$add_roles_permission->name = 'Add Roles';
			$add_roles_permission->save();
			$add_roles_permission->roles()->attach($add_admin_to_role);

			$edit_roles_permission = new Permission();
			$edit_roles_permission->slug = 'edit-roles';
			$edit_roles_permission->name = 'Edit Roles';
			$edit_roles_permission->save();
			$edit_roles_permission->roles()->attach($add_admin_to_role);

			$delete_roles_permission = new Permission();
			$delete_roles_permission->slug = 'delete-roles';
			$delete_roles_permission->name = 'Delete Roles';
			$delete_roles_permission->save();
			$delete_roles_permission->roles()->attach($add_admin_to_role);
		//Permission Permission
			$access_permissions_permission = new Permission();
			$access_permissions_permission->slug = 'access-permissions';
			$access_permissions_permission->name = 'Access Permissions';
			$access_permissions_permission->save();
			$access_permissions_permission->roles()->attach($add_admin_to_role);

			$add_permissions_permission = new Permission();
			$add_permissions_permission->slug = 'add-permissions';
			$add_permissions_permission->name = 'Add Permissions';
			$add_permissions_permission->save();
			$add_permissions_permission->roles()->attach($add_admin_to_role);

			$edit_permissions_permission = new Permission();
			$edit_permissions_permission->slug = 'edit-permissions';
			$edit_permissions_permission->name = 'Edit Permissions';
			$edit_permissions_permission->save();
			$edit_permissions_permission->roles()->attach($add_admin_to_role);

			$delete_permissions_permission = new Permission();
			$delete_permissions_permission->slug = 'delete-permissions';
			$delete_permissions_permission->name = 'Delete Permissions';
			$delete_permissions_permission->save();
			$delete_permissions_permission->roles()->attach($add_admin_to_role);

		



		$user_role = Role::where('slug','user')->first();
		$staff_role = Role::where('slug','staff')->first();
		$add_admin_role_to_user = Role::where('slug', 'admin')->first();
		$add_access_users_permission_to_user = Permission::where('slug','access-users')->first();
		$add_add_users_permission_to_user = Permission::where('slug','add-users')->first();
		$add_edit_users_permission_to_user = Permission::where('slug','edit-users')->first();
		$add_delete_users_permission_to_user = Permission::where('slug','delete-users')->first();



		$adminslug = Str::random(40);
		$i = 0;
		$i = 0;
		while(User::where('slug',$adminslug)->exists())
		{
			$i++;
			$adminslug = Hash::make(Str::random(40).$i);
		}
		$staffslug = Str::random(40);
		$i = 0;
		$i = 0;
		while(User::where('slug',$staffslug)->exists())
		{
			$i++;
			$staffslug = Hash::make(Str::random(40).$i);
		}
		$userslug = Str::random(40);
		$i = 0;
		$i = 0;
		while(User::where('slug',$userslug)->exists())
		{
			$i++;
			$userslug = Hash::make(Str::random(40).$i);
		}
		

		$create_user = new User();
		$create_user->name = 'Filbert Msaki';
		$create_user->mobile = '255762650393';
		$create_user->slug = $userslug;
		$create_user->email = 'msakifil111@gmail.com';
		$create_user->email_verified_at = Carbon::now();
		$create_user->password = bcrypt('12345678');
		$create_user->save();
		$create_user->roles()->attach($user_role);

		$create_admin = new User();
		$create_admin->name = 'Jackson Msaki';
		$create_admin->slug = $adminslug;
        $create_admin->mobile = '255762650392';
		$create_admin->email = 'filymsaki@gmail.com';
		$create_admin->email_verified_at = Carbon::now();
		$create_admin->password = bcrypt('12345678');
		$create_admin->save();
		$create_admin->roles()->attach($add_admin_role_to_user);
		$create_admin->permissions()->attach($add_access_users_permission_to_user);
		$create_admin->permissions()->attach($add_add_users_permission_to_user);
		$create_admin->permissions()->attach($add_edit_users_permission_to_user);
		$create_admin->permissions()->attach($add_delete_users_permission_to_user);


		$create_staff = new User();
		$create_staff->name = 'Jackline Msaki';
		$create_staff->slug = $staffslug;
        $create_staff->mobile = '255762650391';
		$create_staff->email = 'developer.filymsaki@gmail.com';
		$create_staff->email_verified_at = Carbon::now();
		$create_staff->password = bcrypt('12345678');
		$create_staff->save();
		$create_staff->roles()->attach($staff_role);

		
		return redirect()->route('welcome');
    }
}
