<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\OrderNotification;
use Validator;
use Session;
use Auth;

class OrderController extends ExtendController
{
    public function showProcessingOrders(){
        $array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
        Session::push('breadcrumb',['Prodessing Orders'=>route('order.showProcessingOrders'),'active'=>'List']);
        
    	$this->website['orders'] = Order::where('state',"processing")->paginate(20);
    	return view('admin.order.index',$this->website);
    }

    public function showShippingOrders(){
        $array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
        Session::push('breadcrumb',['Shipping Orders'=>route('order.showShippingOrders'),'active'=>'List']);
        $this->website['orders'] = Order::where('state',"shipping")->paginate(20);
        return view('admin.order.index',$this->website);
    }

    public function showDeliveredOrders(){
        $array = Session::pull('breadcrumb');
        Session::forget('breadcrumb');
        Session::push('breadcrumb',$array[0]);
        Session::push('breadcrumb',['Delivered Orders'=>route('order.showDeliveredOrders'),'active'=>'List']);
    	$this->website['orders'] = Order::where('state',"delivered")->latest('updated_at')->paginate(20);
    	return view('admin.order.index',$this->website);
    }

    public function showOrderDetails($id){
        Session::push('breadcrumb',['Order Details'=>route('order.showOrderDetails',$id),'active'=>'Show']);
    	$this->website['order']=Order::findOrFail($id);
    	$this->website['order']->products;
		$this->website['order']->user;
        $this->website['order']->payment;
		//now it sends all details about order , products, and user
    	// return $order;

        // dd($this->website['order']);
        if (Auth::guard('admin')->user()->hasAnyRole(['Admin', 'Super Admin']) ) {
            $notifications = OrderNotification::where('notifiable_id', null)->where('order_id', $id)->where('viewed',0)->get();
            foreach ($notifications as $n) {
                $n->update(['viewed' => true]);
            }
        } else {
            $user_id = Auth::guard('admin')->id(); 
            $notifications = OrderNotification::where('notifiable_id', $user_id)->where('order_id', $id)->where('viewed',0)->get();
            foreach ($notifications as $n) {
                $n->update(['viewed' => true]);
            }
        }
        return view('admin.order.order-dtl',$this->website);
    }

    public function updateOrder($id,Request $request){

    	$order=Order::find($id);

        $validator = Validator::make($request->all(), [
            'state' => 'required|max:15',
        ]);

        $validator->after(function ($validator) use ($order,$request) {
            if ($order->state=="processing" && $request->state=="delivered") {
                $validator->errors()->add('skip', 'You cannot skip step from processing to delivered');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $order->state=$request->state;
        $order->save();
        Session::flash('status', "Order $order->id successfully Updated !");
    	return redirect()->back();
    }

    public function destroy($id){
        $order=Order::find($id);
        $products=$order->products;

        //increase the quantity in product
        foreach($products as $p){
            $product=Product::find($p->id);
            $product->quantity=$product->quantity + $p->pivot->quantityOrdered;
            $product->save();
        }
        $order->products()->detach();
        $order->delete();
        Session::flash('status', "Order $order->id successfully Deleted From Database !");

        return redirect()->route('order.showProcessingOrders');
    }

}
