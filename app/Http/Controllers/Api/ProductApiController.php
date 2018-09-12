<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Resources\ProductResource;
class ProductApiController extends Controller
{
    public function index($s_id){
    	return ProductResource::collection(Product::where('sub_category_id',$s_id)->latest()->paginate(8));
    }

    public function show($id){
    	return response(new ProductResource(Product::findOrFail($id)));
    }

    public function search(Request $request) {
    	return ProductResource::collection(Product::where('name','like','%'.$request->string.'%')
    		->orWhere('description','like','%'.$request->string.'%')->get());
    }
}
