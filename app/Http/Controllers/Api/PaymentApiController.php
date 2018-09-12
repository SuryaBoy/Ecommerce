<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;

class PaymentApiController extends Controller
{
    public function store(Request $request){
    	$payment = Payment::create($request->all());
    	return $payment;
    }
}
