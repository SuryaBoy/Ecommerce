<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

        $this->middleware('checkadmin')->only('create','store','show_admins','destroy');
        
    }

    public function index()
    {
    	$id = Auth::guard('admin')->id();
    	$user = Admin::findOrFail($id);
        return view('admin.dashboard',compact('user'));
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
    	$admins = Admin::where('role_id',2)->get();
    	return view('auth.admin-show',compact('admins'));
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        if($admin->role_id==2){
        	$admin->delete();
        	Session::flash('status', "Admin Deleted Successfully");
        	return redirect(route('admin.dashboard')); 
        }

    	Session::flash('status', "Permission Denied !!");
    	return redirect(route('admin.dashboard')); 

    }
}
