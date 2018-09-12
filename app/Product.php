<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $table = 'products';

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function sub_category()
    {
        return $this->belongsTo('App\SubCategory');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','product_user')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order','order_product')->withPivot('quantityOrdered','unitPrice')
        ->withTimestamps();
    }

    public function image()
    {
    	return Storage::disk('files')->url($this->image);
    	// return asset($this->image);
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }
}
