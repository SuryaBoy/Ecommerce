<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Payment;

class PaymentController extends Controller
{
    public function update(Request $request,Payment $payment)
    {

        $this->validate($request, [
            'status' => 'required|boolean',
            'description' => 'nullable|max:190'
        ]);
        //if the payment state is processing then
        //you cannot change the status of payment
    	if($payment->order->state != 'processing'){
    		$payment->update($request->all());
    		Session::flash('status', "You Have Updated The Payment");
    	}
    	else {
    		Session::flash('failure', "You Cannot Update Payment Yet");	
    	}

    	return redirect()->back();
    }
}
