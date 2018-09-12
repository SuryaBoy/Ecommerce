<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Session;

class SearchController extends ExtendController
{
    public function index(Request $request){
    	$array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
    	$products = Product::where('name','like','%'.$request->q.'%')->get();
    	$this->website['products'] = $products;
    	$this->website['search_word'] = $request->q;
    	return view('admin.search.index',$this->website);
    }

    public function suggest(Request $request){
    	$products = Product::select('name')->where('name','like','%'.$request->word.'%')->get();
    	return response()->json($products);
    }
}
