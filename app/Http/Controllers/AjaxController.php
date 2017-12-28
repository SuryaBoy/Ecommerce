<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\SubCategory;
use App\Category;

class AjaxController extends Controller
{
    public function subcategories($c_id){
    	$subcategories = SubCategory::where('category_id',$c_id)->get();
    	return response()->json($subcategories);
    }
}
