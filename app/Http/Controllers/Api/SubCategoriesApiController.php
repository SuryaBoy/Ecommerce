<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\Http\Resources\SubCategoryResource;

class SubCategoriesApiController extends Controller
{
    public function index(){
    	return response(SubCategoryResource::collection(SubCategory::orderBy('id', 'asc')->get()));
    }
}
