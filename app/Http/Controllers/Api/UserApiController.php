<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UserApiController extends Controller
{
    public function accessToken(Request $request){
        // return response($request);
    	// if(Auth::guard('web')->check()){
    	// 	$user = Auth::guard('web')->user();
    	// 	return response($user);
    	// }
    	// else{
    	// 	$response = array("status"=>401,"statusText"=>"Unauthorized","message"=>"Unauthenticated");
    	// 	return response($response);
    	// }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
            $user = Auth::user();
            return response($user);
        }
        else{
            return response("fail");
        }

    }
}
