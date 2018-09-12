<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $sub_category=$this->sub_category->name;
        $brand = $this->brand->name;
        $array = array_merge(parent::toArray($request),['sub_category'=>$sub_category ,'brand'=>$brand]);
        return $array;
    }
}
