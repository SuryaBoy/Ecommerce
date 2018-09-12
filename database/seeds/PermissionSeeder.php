<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Admin;

class PermissionSeeder extends Seeder
{

    public function run()
    {

		// Reset cached roles and permissions
	    app()['cache']->forget('spatie.permission.cache');

        // create permissions

	    $resource = array('Product','Category','SubCategory','Brand');
	    $action = array('Edit','Create','Delete','View');
	    $role = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
	    Role::create(['guard_name' => 'admin', 'name' => 'Vendor']);
	    $admin = Admin::first();
	    $admin->assignRole('admin');
	    foreach($resource as $r){
	    	foreach($action as $a){
	    		$permission = Permission::create(['guard_name' => 'admin', 'name' => $a.' '.$r]);
	    		$permission->assignRole($role);
	    	}
	    }

    }
}
