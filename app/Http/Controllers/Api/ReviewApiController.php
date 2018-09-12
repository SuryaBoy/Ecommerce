<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;
use App\Http\Resources\ReviewResource;
use Session;

class ReviewApiController extends Controller
{
    public function storeComment(Request $request){
    	$product_id=$request->product_id;
    	$user_id=$request->user_id;

    	$review = Review::where('product_id',$product_id)->where('user_id',$user_id)->first();

    	if(!$review==null){
    		$review->comment = $request->comment;
    	}
    	else{
    		$review = new Review();
    		$review->comment = $request->comment;
    		$review->user_id = $user_id;
    		$review->product_id = $product_id;
    	}

    	$review->save();
    	Session::flash('status', "Your Comment has been successfully posted !");
    	return response("Your Comment has been successfully posted !");

    }

    public function index($p_id){
        return response(ReviewResource::collection(Review::where('product_id',$p_id)->latest('updated_at')->get()));
        // return ReviewResource::collection(Review::latest('updated_at')->get());
    }

}
