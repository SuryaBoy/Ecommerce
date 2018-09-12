<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Session;

class CartApiController extends Controller
{
    public function addItem(Request $request){
    	$product = Product::where('id',$request->product_id)->first();
    	$p = array_merge($product->toArray(),['quantityOrdered'=>1,'total'=>$product->price]);
    	Session::push('cart.items',$p);
    	$items = Session::get('cart.items');
    	return $items;
    }

    public function updateItem(Request $request){
    	$items = Session::get('cart.items');
    	// $product = Product::where('id',1)->first();
    	// $items = array();
    	// array_push($items,array_merge($product->toArray(),['quantityOrdered'=>1,'total'=>$product->price]));

    	$items[$request->index]['quantityOrdered'] = $request->quantityOrdered;
    	$items[$request->index]['total'] = 
    		$items[$request->index]['quantityOrdered'] * $items[$request->index]['price'];
    	return $items;
    }

    public function removeItem(Request $request){
    	$items = Session::get('cart.items');
    	// $product = Product::where('id',1)->first();
    	// $items = array();
    	// array_push($items,array_merge($product->toArray(),['quantityOrdered'=>1,'total'=>$product->price]));
    	// array_push($items,array_merge($product->toArray(),['quantityOrdered'=>2,'total'=>$product->price]));
    	// array_push($items,array_merge($product->toArray(),['quantityOrdered'=>3,'total'=>$product->price]));

    	array_splice($items,$request->index,1);
    	return $items;
    }
}
