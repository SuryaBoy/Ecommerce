<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\OrderNotification;
use App\Notification;

class OrderApiController extends Controller
{

    public function store(Request $request){
    	$order = Order::create($request->all());
        //handle notifications
        OrderNotification::create(['order_id'=>$order->id]);
    	return $order;
    }

    public function storeOrderProduct(Request $request){
    	$order_id=$request->order_id;
    	$product_id=$request->product_id;
    	$order=Order::find($order_id);
    	$order->products()->attach([$product_id=>['quantityOrdered'=>$request->quantityOrdered,'unitPrice'=>$request->unitPrice]]);

        //decrease the quantity in product
        $product=Product::find($product_id);
        $product->quantity=$product->quantity-$request->quantityOrdered;
        $product->save();

        //handle notification for vendors for their products
        if($product->admin != null){
            $oN=$product->admin->orderNotifications()->create([
                'order_id'=>$order_id,
            ]);
        }
    	return $order->products()->where('product_id',$product_id)->first();
    }

    public function getOrders($user_id){
        $orders = Order::where('user_id',$user_id)->latest('created_at')->get();
        return $orders;
    }

    public function getOrderDetails($order_id){
    	$order=Order::find($order_id);
    	$order->products;
		$order->user;
		//now it sends all details about order , products, and user
    	return $order;
    }

}
