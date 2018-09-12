<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user_name=$this->user->name;
        $array = array_merge(parent::toArray($request),['user_name'=>$user_name]);
        return $array;
    }
}
