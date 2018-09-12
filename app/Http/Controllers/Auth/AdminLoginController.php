<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Admin;

class AdminLoginController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest:admin')->except('adminLogout');
	}

    public function showLoginForm(){
    	return view('auth.admin-login');
    }

    public function login(Request $request){
    	// validate the data
    	$this->validate($request, [
    		'email'=>'required|email',
    		'password'=>'required|min:6',
    		]);


    	// Attempt to login

    	if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password], $request->remember)){
    	// if successful then redirect to intended location
    		return redirect()->intended(route('admin.dashboard'));
    	}
    	
    	// if unsuccessful the redirect back to login form
    	return redirect()->back()->withInput($request->only('email','remember'));
    }


    public function adminLogout(Request $request)
    {
        if(Auth::guard('web')->check()){
            Auth::guard('admin')->logout();
            return redirect('/');
        }

        Auth::guard('admin')->logout();      
        $request->session()->invalidate();
        return redirect('/');

    }

}
