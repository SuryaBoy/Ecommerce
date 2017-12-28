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

    public function image()
    {
    	return Storage::disk('files')->url($this->image);
    	// return asset($this->image);
    }
}
