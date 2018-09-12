<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderNotification extends Model
{
    protected $fillable = ['order_id','viewed', 'notifiable_id', 'notifiable_type'];

	public function notifiable()
    {
        return $this->morphTo();
    }
}
