<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Resources\CategoryResource;

class CategoriesApiController extends Controller
{
    public function index(){

    	return response(CategoryResource::collection(Category::orderBy('id', 'asc')->get()));
    }
}
