<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'order_id', 'description', 'status', 'method',
    ];

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

    public function status()
    {
    	return $this->status?"Paid":"Payment Pending";
    }
}
