<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id', 'delivered', 'total',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product','order_product')->withPivot('quantityOrdered','unitPrice')
        ->withTimestamps();
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

}
