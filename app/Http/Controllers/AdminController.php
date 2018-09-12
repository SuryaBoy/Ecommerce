<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\OrderNotification;
use Auth;
use Illuminate\Support\Facades\Session;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends ExtendController
{

    public function __construct()
    {

        $this->middleware('auth:admin');

        $this->middleware('checkadmin')->only('create','store','show_admins','destroy');
        
        //i dont know but i had to make this even i extended the ExtendController it might be because
        // of constructur
        $this->middleware(function ($request, $next) {
            $user = Auth::guard('admin')->user();
            $notifications;
            if ($user->hasRole('Vendor')) {
                $notifications= Auth::guard('admin')->user()->OrderNotifications()->where('viewed', 0)->get();
                $this->website['notifications'] = $notifications;
            }
            else {
                $notifications = OrderNotification::where('viewed', 0)->where('notifiable_id', null)->get();
                $this->website['notifications'] = $notifications;
            }
            
            return $next($request);
        });

    }

    public function index()
    {
    	$id = Auth::guard('admin')->id();
    	// $user = Admin::findOrFail($id);
        $this->website['user'] = Admin::findOrFail($id);
        Session::forget('breadcrumb');
        Session::push('breadcrumb',['Home'=>route('admin.dashboard'),'active'=>'Dashboard']);
        return view('admin.dashboard',$this->website);
    }

    public function create(){
    	return view('auth.admin-register');
    }

    public function store(Request $request){

		$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'job_title' => 'required|string|max:255',
		]);

		Admin::create(
				[
					'name'=>$request->name,
					'email'=>$request->email,
					'password'=>bcrypt($request->password),
					'job_title'=>$request->job_title,
				]
			);

		Session::flash('status', "New Admin $request->name successfully Created !");
		return redirect(route('admin.dashboard'));

    }

    public function show_admins(){
    	// $admins = Admin::where('role_id',2)->get();
        $admins = Admin::all();
    	return view('auth.admin-show',compact('admins'));
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles

        return view('auth.admin-edit', compact('admin', 'roles')); //pass user and roles data to view
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
        $admin = Admin::findOrFail($id); //Get role specified by id

        $roles = $request['roles']; //Retreive all roles

        if (isset($roles)) {        
            $admin->roles()->sync($roles);  //If one or more role is selected associate user to roles          
        }        
        else {
            $admin->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        Session::flash('status', "Admin successfully edited.!!");
        return redirect()->route('admin.show');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        if(!$admin->hasRole('Super Admin')){
        	$admin->delete();
        	Session::flash('status', "Admin Deleted Successfully");
        	return redirect(route('admin.dashboard')); 
        }

    	Session::flash('status', "Permission Denied !!");
    	return redirect(route('admin.dashboard')); 

    }
}
