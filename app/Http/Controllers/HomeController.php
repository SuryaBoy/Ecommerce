<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\SubCategory;
use App\Category;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $products=Product::all();
        $subcategories=SubCategory::all();
        $brands = Brand::all();
        return view('home',compact('products','subcategories','brands'));
    }

    public function getCat(Request $request)
    {
        if($request->ajax())
        {
            $data = Category::where('name', $request->name)->get();
            return response()->json($data);
        }
    }
}